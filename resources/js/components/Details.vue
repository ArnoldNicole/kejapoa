<template>
	<div class="row justify-content-center">
		<div class="col-lg-4 my-auto" v-for="(house, h) in houses" :key="house.id">
		  <div class="device-container">
		    <div class="device-mockup iphone6_plus portrait white">
		      <div class="device">
		        <div class="screen">
		          <img v-bind:src="'/uploads/'+house.iconImage" class="img-fluid" alt="">
		        </div>
		        <div class="center">
		        	{{house.house_name}}
		        </div>
		        <div class="button text-center">
		          <button class="btn btn-info text-white font-weight-bold" @click="viewHouseProperties(house, h)">Details</button>
		        </div>
		      </div>
		    </div>
		  </div>
		<Modal :closable="true" :width="80" class="custom" v-model="view_modal" :mask-closable="false">
			<div slot="header">
				<h2 class="text-center">HOUSE DETAILS</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card-body">
						<h3 class="text-info">{{view.house_name}}</h3>
						<p>Located at {{view.geo_location}}</p>
						<p>condition : {{view.condition}}</p>
						<p>Monthly Rent: {{view.rent_amount}}</p>
						<p>Currently {{view.status}}</p>
						<div class="container-fluid" v-html="view.description"></div>						
					</div>
				</div>
				<div class="col-md-12">
					<div class="row container-fluid"  v-if="view.images.length">
						<div class="col-md-4" v-for="image in view.images">
							<img :src="'/uploads/'+image.image"  class="img-fluid">
						</div>
					</div>
				</div>
			</div>
			<div slot="footer">
				<Button v-if="authenticated" type="info"><a :href="'/chat/contact_landlord/intent/'+view.id" target="_blank">Contact Landlord</a>
				</Button>
				<Button v-else type="error"><a :href="'/register'" target="_blank">Register, to contact landlord</a>
				</Button>
			</div>
		</Modal>
	</div>
</div>
</template>
<script>
	export default{
		props:['houses','authenticated'],
		data(){
			return {
				view_modal:false,
				view:{
					condition: "",
					created_at: "",
					description: "",
					geo_location: "",
					house_name: "",
					id: "",
					rent_amount: "",
					rooms: "",
					status: "",
					updated_at: "",
					user_id: "",
					images:[],
				}
			}
		},
		methods:{
			viewHouseProperties(house,index){
				this.view = house
				this.view_modal = true;
			}
		},
		created(){
			console.log(this.houses)
		}
	}
</script>
<style scoped>
	.screen{
		position: relative !important;
	}
	.img{

	}
 .center {
  position: absolute;
  top: 50%;
  width: 100%;
  text-align: center;
  font-size: 18px;
  background: rgba(39,62,84,0.82);
  opacity: 0.5;
  height: inherit;
}
</style>