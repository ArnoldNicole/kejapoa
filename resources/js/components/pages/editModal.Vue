<Modal 
	v-model="editHouseModal"
	title="Edit House Dialogue Box"
	:mask-closable='false'
	:closable='false'
	:fullscreen='true'>

	<div slot="header">
		<Button type="error" @click="editHouseModal=false">Close</Button>
		<Button type="info" @click='editHouse'>Save Changes</Button>
		<p>Fill the form below to create a new house in the system </p>
	</div>

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
			<vue-editor v-model="editData.description"/>
			<!-- <div v-html="editData.description">
			</div> -->					
		</div>
	</div>
	<div slot="footer">
		Use the save button on top of this Window
	</div>

</Modal>