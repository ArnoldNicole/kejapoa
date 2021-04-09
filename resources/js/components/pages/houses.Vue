<template>
	<div class="row justify-content-center">	
		<div class="col-md-12">
		<Button @click="addHouseModal=true"><Icon type="md-add"/> Add House</Button>
		
		<div>
			<div style="width: 98%">
				<table class="table table-hover table-responsive-sm">
					<thead>
						<tr class="bg-info">
							<th>#.</th>
							<th>House Name</th>
							<th>Geo Location</th>
							<th>Created at</th>
							<th>Status</th>							
							<th>Action</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="bg-light">
						<tr v-for="(house, i) in houses" :key="i" v-if="houses.length">
							<td scope="row">{{house.id}}</td>
							<td>{{house.house_name}}</td>
							<td>{{house.geo_location}}</td>
							<td>{{house.created_at}}</td>
							<td>{{house.status}}</td>
								<Button type="info" size="small" @click="showHouseEditModal(house, i)">Edit</Button>								
							</td>
							<td>
								<router-link :to="'/house/'+house.id"><Button type="info" size="small">House Profile</Button></router-link>
							</td>
						</tr>
						<hr>
					</tbody>
				</table>
			</div>
		</div>
		<Modal 
			v-model="addHouseModal"
			title="Add a House Dialogue Box"
			:mask-closable='false'
			:closable='false'
			:width="95">
			<div class="form-group row">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">House Name (Unique)</label>

				<div class="col-md-8">
					<input v-model="data.house_name" placeholder="Give your house a name" class="form-control" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">Location of house</label>
				<div class="col-md-8">
					<input v-model="data.geo_location" placeholder="Enter house google co-ordinates" class="form-control" />
					<Button type="default" @click="locatorButtonPressed"><Icon type="md-locate"/> Get My Location</Icon>
					</Button>
				</div>
			</div>
			<div class="row form-group">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">Status</label>
				<div class="col-md-8">
					<input v-model="data.status" placeholder="House vacancy status" class="form-control" />
					
				</div>
			</div>
			<div class="row form-group">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">Rooms</label>
				<div class="col-md-8">
					<input v-model="data.rooms" placeholder="Number of rooms in the house" class="form-control" />
					
				</div>
			</div>
			<div class="row form-group">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">Condition</label>
				<div class="col-md-8">
					<input v-model="data.condition" placeholder="House condition, old, new etc" class="form-control" />
					
				</div>
			</div>

			<div class="row form-group">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">Rent Amount (Monthly)</label>
				<div class="col-md-8">
					<input v-model="data.rent_amount" placeholder="House monthly rent" class="form-control" />
					
				</div>
			</div>
			
			<div class="row form-group">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">Description</label>
				<div class="col-md-8">
				<vue-editor useCustomImageHandler @image-added="handleImageAdded" v-model="data.description"/>
				</div>
			</div>

			<div class="row form-group">
				<label class="col-form-label font-weight-bold col-md-4 text-md-right">Cover Image</label>
				<div class="col-md-8">					
					<Upload
					      ref="uploads"
					      type="drag"
					      :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
					      :on-success="handleSuccess"
					      :on-error="handleError"
					      :format="['jpg','jpeg','png']"
					      :max-size="1024"
					      :on-format-error="handleFormatError"
					      :on-exceeded-size="handleMaxSize"
					      action="/app/upload">
					    
					      <div style="padding: 20px 0">
					        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
					        <p>Click or drag files here to upload</p>
					      </div>
					    </Upload>
					    <div class="demo-upload-list" v-if="data.iconImage">
					       <img class="img-thumbnail w-50" :src="'/uploads/'+data.iconImage" />
					      <div class="demo-upload-list-cover">
					        <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
					      </div>
					    </div>
				</div>
			</div>

			<div slot="footer">
				<Button type="error" @click="addHouseModal=false">Close</Button>
				<Button type="info" :loading="isAdding" :disabled="isAdding" @click="addHouse">{{isAdding ? 'Saving...' : 'Save House'}}</Button>
			</div>
		</Modal>

		<Modal 
			v-model="editHouseModal"
			title="Edit House Dialogue Box"
			:mask-closable='false'
			:closable='false'
			:fullscreen='true'>
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">House Name</label>
				<div class="col-md-8">
					<input v-model="editData.house_name" placeholder="Edit your House name" class="form-control" />					
				</div>
			</div>			
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">House Location</label>
				<div class="col-md-8">
					<input v-model="editData.condition" placeholder="Whats the current condition of the house" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">Rent Amount</label>
				<div class="col-md-8">
					<input v-model="editData.rent_amount" placeholder="How much are you charging monthly?" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">Rooms</label>
				<div class="col-md-8">
					<input v-model="editData.rooms" placeholder="How many rooms does your house have?" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 text-md-right col-form-label font-weight-bold">Description</label>
				<div class="col-md-10">
					<vue-editor class="work_area" useCustomImageHandler @image-added="handleImageAdded" v-model="editData.description"/>
					<!-- <div v-html="editData.description">
					</div> -->					
				</div>
			</div>
			<div slot="footer">
			<Button type="error" @click="editHouseModal=false">Close</Button>
			<Button type="info" @click='editHouse'>Save Changes</Button>
			</div>

		</Modal>
		</div>
	</div>
</template>
<script>
import { VueEditor } from "vue2-editor";
export default {
	data(){
		return {
			data:{
				house_name:'',
				geo_location:'',				
				status:'',
				condition:'',
				rooms:'',
				description:'',
				rent_amount:'',
				iconImage:'',

			},
			token:'',
			isAdding:false,
			loading:false,
			addHouseModal:false,
			houses:[],
			editHouseModal:false,
			editData: {
				house_name:'',				
				condition:'',
				rooms:'',
				description:'',
				rent_amount:''
							
				
			},
			index : 1,
		}
	},
	methods: {
		handleImageAdded(){
			return this.e('Please dont upload images using this form, a separate page for images exists.')
		},
		async addHouse(){
			this.isAdding =true
			if (this.data.house_name.trim()=='') {
				this.isAdding =false
				return this.e('House Name is Required')
			}
			if (this.data.geo_location.trim()=='') {
				this.isAdding =false
				return this.e('House geolocation is Required')
			}
			if (this.data.status.trim()=='') {
				this.isAdding =false
				return this.e('House status is Required')
			}
			if (this.data.condition.trim()=='') {
				this.isAdding =false
				return this.e('Please provide the condition of the house')
			}
			if (this.data.rooms.trim()=='') {
				this.isAdding =false
				return this.e('We`d love to know the number of rooms available')
			}
			if (this.data.description.trim()=='') {
				this.isAdding =false
				return this.e('Please provide a description for the house')
			}
			if (this.data.rent_amount.trim()=='') {
				this.isAdding =false
				return this.e('Tenants need to know the rent amount')
			}
			if (this.data.iconImage.trim()=='') {
				this.isAdding =false
				return this.e('Please upload an image')
			}
			const res= await this.callApi('post', '/landlord/addHouse', this.data)
			if (res.status==201) {
				this.houses.unshift(res.data);
				this.s('House Added Successfully')
				this.addHouseModal=false
				this.data.house_name=''
				this.data.geo_location=''
				this.data.status=''
				this.data.rooms=''
				this.data.condition=''
				this.data.description=''
				this.data.rent_amount=''
				this.data.iconImage = ''
			}else{
				if (res.status==422) {
					for (let i in res.data.errors) {
						this.e(res.data.errors[i][0])
					}
				}
				else{
					if (res.status==401) {
						this.e('Your session ended unexpectedly.')
						window.location='/profile';
					}
						else{
							this.swr('Unexpectd error occured')
						}
					
				}
			}
		},
		async editHouse(){
			if (this.editData.house_name.trim()=='') {
				return this.e('House Name is Required')
			}
			if (this.editData.rooms.trim()=='') {
				return this.e('Please provide number of rooms')
			}
			if (this.editData.description.trim()=='') {
				return this.e('Check your description')
			}
			if (this.editData.condition.trim()=='') {
				return this.e('Condition is required')
			}
			if (this.editData.rent_amount.trim()=='') {
				return this.e('House Rent Amount is Required')
			}
			
			const res= await this.callApi('post', '/landlord/editHouse', this.editData)
			if (res.status==200) {
				this.houses[this.index].house_name = this.editData.house_name				
				this.houses[this.index].rooms = this.editData.rooms
				this.houses[this.index].condition = this.editData.condition
				this.houses[this.index].rent_amount = this.editData.rent_amount
				this.houses[this.index].description = this.editData.description
				this.s('House Data updated Successfully')
				this.editHouseModal=false				
			}else{
				if (res.status==422) {
					if (res.data.errors.house_name) {
						this.e(res.data.errors.house_name[0])
					}
					if (res.data.errors.condition) {
						this.e(res.data.errors.condition[0])
					}
					if (res.data.errors.rooms) {
						this.e(res.data.errors.rooms[0])
					}
					if (res.data.errors.description) {
						this.e(res.data.errors.description[0])
					}
					if (res.data.errors.rent_amount) {
						this.e(res.data.errors.rent_amount[0])
					}
				}else{
					if (res.status==401) {
						this.e('Unauthorized action')
						window.location='/login'
					}else{
						this.swr(res.data.errors) 
					}
				}
			}

		},
		locatorButtonPressed() {
		this.i('Please be patient as we find your co-ordinates')
		  navigator.geolocation.getCurrentPosition(
		     position => {
		       //console.log(position.coords.latitude);
		       //console.log(position.coords.longitude);		       
		       this.getStreetAddressFrom(position.coords.latitude, position.coords.longitude)
		       
		     },
		     error => {		     	
		       this.e(error.message);
		       console.log(error.message);
		     },
		  )   
		},

		async getStreetAddressFrom(lat, long) {
		  try {
		    var { data } = await axios.get(
		      "https://cors-anywhere.herokuapp.com/https://maps.googleapis.com/maps/api/geocode/json?latlng=" +
		        lat +
		        "," +
		        long +
		        "&key=AIzaSyBn5MgwK80_rI1D8TL1u272jEkCvQHdNeY"
		    );
		    if(data.error_message) {
		      console.log(data.error_message)
		    } else {
		      this.data.geo_location = data.results[0].formatted_address;
		    }
		  } catch (error) {
		    console.log(error.message);
		  } 
		},
		showHouseEditModal(house, index){
			let object = {
				id: house.id,
				house_name : house.house_name,
				geo_location: house.geo_location,
				rooms: house.rooms,
				condition: house.condition,
				description: house.description,
				rent_amount: house.rent_amount
			}

			this.editData = object
			this.editHouseModal = true
			this.index= index
		},
		handleSuccess(res, file) {
		     res = `${res}`;
		     this.data.iconImage = res;
		   },

		   handleError(res, file) {
		     this.$Notice.warning({
		       title: "The file format is incorrect",
		       desc: `${
		         file.errors.file.length
		           ? file.errors.file[0]
		           : "Something went wrong!"
		       }`
		     });
		   },
		   handleFormatError(file) {
		     this.$Notice.warning({
		       title: "The file format is incorrect",
		       desc:
		         "File format of " +
		         file.name +
		         " is incorrect, please select jpg or png."
		     });
		   },

		   handleMaxSize(file) {
		     this.$Notice.warning({
		       title: "Exceeding file size limit",
		       desc: "File  " + file.name + " is too large, no more than 2M."
		     });
		   },
		   deleteImage(isAdd = true) {              
		       this.data.iconImage = "";
		       this.$refs.uploads.clearFiles();
		    }

	},
	async created(){
		this.token = window.Laravel.csrfToken;
		const res= await this.callApi('get', '/landlord/myhouses')
		if (res.status === 200) {
			this.s('Houses loaded Successfully')
			this.houses = res.data
		}
		else{
			this.e('Something went wrong while loading houses')
		}
	}
	
}
</script>


<style scoped>
	.work_area{
		max-height:350px;
		overflow-y: scroll;
		margin-bottom: 3rem;
	}
</style>