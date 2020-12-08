import Router from 'vue-router'
import Vue from 'vue'
Vue.use(Router)
import Houses from './components/pages/houses'
import Profile from './components/pages/profile'
import House from './components/pages/house'
import CreateAgent from './components/pages/create_agent'
import Agents from './components/pages/agents'
import ImageUploader  from './components/pages/ImageUpload'
import HouseImageUploader from  './components/pages/HouseImageUpload'



const routes = [
    //projects routes....      
    {
    	path: '/addHouses',
    	component: Houses,
    },
    
    {
    	path: '/profile',
    	component: Profile,
    },
     {
    path: '/house/:id',    
    component: House
  },

  {
    path: '/agents/create',    
    component: CreateAgent,
  },
  {
    path: '/agents/manage',
    component: Agents,
  },
  {
    path:'/user/editImage',
    component: ImageUploader,
  },
  {
    path:'/house/upload/:id',
    component: HouseImageUploader,
  }

]



export default new Router({
    mode: 'history',
    routes

})
