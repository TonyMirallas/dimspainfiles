<template>
  
   <el-form 
      class="form-entities"
      ref='ruleFormRef'
      :model="form"
      :rules="rules"
      label-position="top"
   >

      <template v-for="item in form">

         <div v-if="item.type == 'title' && !item.hide" class="title" :key="item.key" :style="item.size">
            {{item.label}}
         </div>

         <div v-if="item.type == 'line' && !item.hide" class="line" :key="item.key" :style="item.size"></div>
         <div v-if="item.type == 'line-hard' && !item.hide" class="line-hard" :key="item.key" :style="item.style"></div>

         <template v-if="item.type == 'input' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-input size="large" v-model="item.value" :disabled="item.disabled"></el-input>
            </el-form-item>
         </template>
         
         <template v-if="item.type == 'number' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-input-number size="large" v-model="item.value" :disabled="item.disabled" :controls-position="item.controlsPosition" :controls="item.controls"/>
            </el-form-item>
         </template>

         <template v-if="item.type == 'checkbox' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-checkbox
                  size="large"
                  :disabled="item.disabled"
                  v-model="item.value"
                  :true-label="1" :false-label="0" 
                  :label="item.value ? 'Activado' : 'Desactivado'" border>
               </el-checkbox>
            </el-form-item>
         </template>

         <template v-if="item.type == 'select' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-select size="large" v-model="item.value" :disabled="item.disabled">
                  <el-option v-for="option in item.options" 
                     :key="option.key" :label="option.label" :value="option.key">
                  </el-option>
               </el-select>
            </el-form-item>
         </template>

         <template v-if="item.type == 'select-multiple' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-select size="large" v-model="item.value" multiple :disabled="item.disabled">
                  <el-option v-for="option in item.options" 
                     :key="option.key" :label="option.label" :value="option.key">
                  </el-option>
               </el-select>
            </el-form-item>
         </template>

         <template v-if="item.type == 'textarea' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-input size="large" v-model="item.value" type="textarea" :disabled="item.disabled"></el-input>
            </el-form-item>
         </template>
         
         <template v-if="item.type == 'datepicker' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-date-picker size="large" v-model="item.value" format="DD/MM/YYYY" type="date" />
            </el-form-item>
         </template>

         <template v-if="item.type == 'datepickertime' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <el-date-picker size="large" v-model="item.value" format="DD/MM/YYYY HH:mm" type="datetime" />
            </el-form-item>
         </template>
         
         <template v-if="item.type == 'component' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <component :is="item.component" v-model="item.value"></component>
            </el-form-item>
         </template>

         <template v-if="item.type == 'slot' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.label" :prop="item.key" :key="item.key" :style="item.size">
               <slot :name="item.key" :item="item"></slot>
            </el-form-item>
         </template>

         <template v-if="item.type == 'submit' && !item.hide">
            <el-form-item :class="item.key" :required="item.required" :label="item.labelDisabled ? null : item.label" :key="item.key" :style="item.size" class="visibility-hidden">
               <el-button :type="item.typeStyle || 'primary'" size="large" class="btn-submit" @click="formSubmit(ruleFormRef, item)" :disabled="item.disabled">
                  {{item.label}}
               </el-button>
            </el-form-item>
         </template> 

      </template>

   </el-form>

</template>

<script>

   import { ref } from 'vue'
   import ElementPlus from 'element-plus'

   const validatorLen = (rule, item, callback) => {
      if (!item.value || item.value.length <= 0 || item.value.length == rule.len ) return callback()
      return callback(new Error(rule.message))
   }

   const validatorFormatEmail = (rule, item, callback) => {
      if (
         !item.value ||
         item.value.length <= 0 ||
         item.value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/)){
         return callback()
      }else{
         return callback(new Error(rule.message))
      }
   }

   const validatorNotEmpty = (rule, item, callback) => {
      if (!item.value || item.value.length <= 0) return callback(new Error(rule.message))
      return callback()
   }

   const validatorDistinct = (rule, item, callback) => {

      for(let distinct of item.distinct){
         if (item.value == rule.form[distinct.key].value) return callback(new Error(distinct.message))
      } 

      return callback()

   }

   export default {

      name: 'TechnicalProfileEntities',
      props: { 
         form: {
            type: Object,
            default: {}
         }
      },
      setup(props, context){

         const rules = {}
         
         for (let formKey in props.form) {

            const { key, required, typeRule, len, distinct } = props.form[formKey]

            if(!key) continue

            rules[key] = []

            if(required){
               rules[key].push({
                  validator: validatorNotEmpty, typeRule, message: `Campo Obligatorio`, trigger: ['blur', 'change']
               })
            }

            if(typeRule == 'email'){
               rules[key].push({
                  validator: validatorFormatEmail, typeRule, message: `Correo no valido`, trigger: ['blur', 'change']
               })
            }

            if(len){
               rules[key].push({ 
                  validator: validatorLen, len, message: `Solo se permiten ${len} caracteres`, trigger: ['blur', 'change']
               })
            }

            if(distinct){
               rules[key].push({
                  validator: validatorDistinct, typeRule, form: props.form, trigger: ['blur', 'change']
               })
            }


         }

         const formSubmit = async (formEl, item) => {

            if (!formEl) return 

            await formEl.validate((valid, fields) => {

               if (valid) return context.emit('onSubmit', item)
               return false

            })
            
         }

         return {
            rules,
            ruleFormRef: ref(ElementPlus.FormInstance),
            formSubmit,
         }

      }

   }

</script>



<style lang="scss" scoped>

   .form-entities{
      display: flex;
      flex-wrap: wrap;
      gap: 0 20px;

      .el-select{
         width: 100%;
      }

      .el-checkbox.is-bordered{
         width: 100%;
         padding: 12px !important;
      }

      .line{
         height: 1px;
         background: #efefef;
         width: 100%;
         margin: 20px 0 5px 0;
      }
      
      .line-hard{
         width: 100%;
         display: block;
         border-bottom: solid 1px #cc181f;
         margin: 20px 0;
      }

      .title{
         width: 100%;
         display: block;
         font-size: 18px;
         font-weight: 500;
         border-bottom: solid 1px #cc181f;
         color: #cc181f;
         padding: 20px 0 10px 0;
         margin-bottom: 10px;
      }

   }
   
</style>