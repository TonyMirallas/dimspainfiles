
<template>

  <div class="test">

		<div v-for="(index, item) in persona" :key="index">

			<div>
				{{item}}: {{persona[item]}}	
			</div>
		
			<el-input v-model="persona[item]"></el-input>

		</div>
	
  </div>
  
</template>

<script>

import { ref, onMounted } from 'vue';

export default {

	name: 'Tester',
	props: {
		persona: {
			type: Object,
			default: {}
		},
	},
	setup(props){
		

		return {

		}

	}

}

</script>

<style lang="scss">



</style>