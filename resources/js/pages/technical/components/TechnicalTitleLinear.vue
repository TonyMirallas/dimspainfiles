<template>

   <div class="title" :style="`border-bottom: solid 1px ${color};`" :class="{ 'padding-top-rm': paddingTopRm }">
      {{title}}
   </div>

</template>

<script>

   export default {
      name: 'TechnicalTitleLinear',
      props: {
         title: String,
         color: String,
         paddingTopRm: Boolean,
      },
      setup(props){ }
   }

</script>


<style lang="scss" scoped>

   .padding-top-rm{
      padding-top: 0 !important;
   }

   .title{
      width: 100%;
      display: block;
      font-size: 18px;
      font-weight: 500;
      border-bottom: solid 1px #cc181f;
      color: #cc181f;
      padding: 20px 0 10px 0;
      // margin-bottom: 10px;
   }

</style>