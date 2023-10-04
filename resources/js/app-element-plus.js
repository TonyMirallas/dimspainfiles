import ElementPlus from "element-plus";
import locale from "element-plus/lib/locale/lang/es";
import dayjs from "dayjs";
import 'dayjs/locale/es'

dayjs.locale('es')

// import 'element-plus/theme-chalk/index.css'
import 'element-plus/dist/index.css'

import { 
   InfoFilled,
   User, 
   UserFilled, 
   CirclePlus, 
   CirclePlusFilled,
   Histogram, 
   Tickets, 
   SwitchButton, 
   Tools, 
   ArrowRightBold,
   CreditCard,
   Grape,
   List,
   Search,
} from '@element-plus/icons'


// Export icons
export default {
   ElementPlus,
   locale,
   icons: [
      {name: 'InfoFilled',  component: InfoFilled },
      {name: 'User',  component: User },
      {name: 'Histogram',  component: Histogram },
      {name: 'Tickets',  component: Tickets },
      {name: 'UserFilled',  component: UserFilled },
      {name: 'SwitchButton',  component: SwitchButton },
      {name: 'Tools',  component: Tools },
      {name: 'CirclePlus',  component: CirclePlus },
      {name: 'CirclePlusFilled',  component: CirclePlusFilled },
      {name: 'ArrowRightBold',  component: ArrowRightBold },
      {name: 'CreditCard',  component: CreditCard },
      {name: 'Grape',  component: Grape },
      {name: 'List',  component: List },
      {name: 'Search ',  component: Search},
   ]
}