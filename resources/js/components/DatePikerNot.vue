
<template>

	<el-dialog v-model="calendarTaskListVisible" title="Seguimientos" width="80%" >
		
		<TablePro :columnData="tableData" :column-order="tableDataOrder" filterSearch="" :items-for-page="50">

			<template v-slot:finished_at="slotProps">
				<span>{{dateToFormat(slotProps.item.finished_at)}}</span>
			</template>

			<template v-slot:company_name="slotProps">
				<router-link :to="{ name: 'customer_profile_company', params: { entityId: slotProps.item.customer_id, entityType: slotProps.item.customer.type  } }">
					{{slotProps.item.customer.name}}
				</router-link>
			</template>

			<template v-slot:company_contact="slotProps">
				<router-link :to="{ name: 'customer_profile_contacts', params: { entityId: slotProps.item.customer_id, entityType: slotProps.item.customer.type } }">
					{{slotProps.item.contact.name}}
				</router-link>
			</template>

			<template v-slot:company_phone="slotProps">
          {{slotProps.item.contact.phone}}
			</template>

			<template v-slot:state="slotProps">
				<div :class="slotProps.item.state">{{stateString[slotProps.item.state]}}</div>
			</template>

			<template v-slot:open="slotProps">
				<router-link :to="{ name: 'customer_profile_tracing', params: { entityId: slotProps.item.customer_id, entityType: slotProps.item.customer.type } }">
					Abrir
				</router-link>
			</template>

		</TablePro>
		
	</el-dialog>
  
    <div class="vc-container" v-loading="loading">
      <Calendar
        class="custom-calendar max-w-full"
        :masks="masks"
        :attributes="attributes"
        disable-page-swipe
        is-expanded
      >
        <template v-slot:day-content="{ day, attributes }">
          <div class="day-content">
            <div class="day-number">
              <div class="day-number-value">{{ day.day }}</div>
            </div>
            <div v-if="attributes && attributes.length > 0" class="day-task">
              <div class="day-task-val" @click="eventListTask(attributes)">
                {{attributes.length}}
              </div>
            </div>
          </div>
        </template>
      </Calendar>
    </div>
  
</template>

<script>

import { ref, onMounted } from 'vue';
import dayjs from 'dayjs';

import 'v-calendar/dist/style.css';

import * as serviceTracing from '../services/serviceTracing';

export default {

	name: 'DatePikerNot',
	props: {},
	setup(props){
		
		const loading = ref(false)
		const tableData = ref([])

		const tableDataOrder = [
			{ label: 'Empresa', type:"slot", slot: 'company_name' },
			{ label: 'contacto', type:"slot", slot: 'company_contact' },
			{ label: 'Objetivo', type:"text", field: 'objetive' },
			{ label: 'Estado', type:"slot", slot: 'state' },
			{ label: '', type:"slot", slot: 'open' },
		]

		const dateToFormat = (date) => dayjs(date).format('DD/MM/YYYY');

		const stateString = {
			'open': 'Abierto',
			'closed': 'Cerrado',
			'cancelled': 'Cancelado',
		}

		const attributes = ref([])
		const calendarTaskListVisible = ref(false);

		const masks = { weekdays: 'WWW' }

		const eventListTask = (data) => {

			const tasks = data.map( ({customData}) => customData )

			tableData.value = tasks

			calendarTaskListVisible.value = true

		}

		onMounted( async () => {

			loading.value = true

			const tracings = await serviceTracing.getTracings()

			const tasksToday = tracings.filter( tracing => {
				return tracing.state === 'open'
			}).map( task => {
				return {
					key: task.id,
					customData: task,
					dates: new Date(task.finished_at),
				}
			})

			attributes.value = tasksToday

			loading.value = false

		})

		return {

			loading,
			stateString,
			
			tableData,
			tableDataOrder,
			
			calendarTaskListVisible,
			masks,
			attributes,

			dateToFormat,
			eventListTask

		}
	}

}

</script>

<style lang="scss">

  .vc-container {

    border: none;

    --day-border: 1px solid #efefef;
    --day-border-highlight: 1px solid #efefef;
    --day-width: 90px;
    --day-height: 90px;
    --weekday-bg: #f9f9f9;
    --weekday-border: 1px solid #efefef;

    border-radius: 0;
    width: 100%;

    & .vc-header {
      background-color: #f9f9f9;
      padding: 10px 0;
    }

    & .vc-weeks {
      padding: 0;
    }

    & .vc-weekday {
      background-color: var(--weekday-bg);
      border-bottom: var(--weekday-border);
      border-top: var(--weekday-border);
      padding: 5px 0;
    }

    & .vc-day {
      overflow: hidden;
      font-size: 13px;
      padding: 5px;
      text-align: left;
      height: var(--day-height);
      min-width: var(--day-width);
      background-color: white;
      border: solid 1px #f0f0f0;

      &.weekday-1, &.weekday-7 {
        background-color: #eff8ff;
      }

    }

    & .vc-day-dots {
      margin-bottom: 5px;
    }

    .weekday-position-6{
        background: #f9f9f9b3 !important;
    }
    .weekday-position-7{
        background: #f9f9f9b3 !important;
    }

    .day-content{
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .day-number-value{
      font-weight: 600;
    }

    .day-task{
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  
    .day-task-val {
      background: #2196f3;
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 18px;
      color: white;
      font-weight: 700;
      border-radius: 5px;
      cursor: pointer;

    }

    .day-task-val:hover{
      background-color: #166aad;
    }

	 .is-today{
		color: red !important;
	 }


  }

  
    .open{
        color: #00b300;
    }

    .closed{
        color: #ff0000;
    }

    .cancelled{
        color: #ffa500;
    }


</style>