<template>
	<div class="row justify-content-center">	
		<div class="col-md-12">
		<router-link to="/agents/create"><Icon type="md-add"/> Add agent</router-link>
		
		<div>
			<div>
				<table class="table table-hover table-responsive-sm">
					<thead>
						<tr class="bg-info">
							<th>#.</th>
							<th>agent User Name</th>
							<th>Email</th>
							<th>Created at</th>							
							<th>Date of Birth</th>
							<th>Gender</th>							
							<th>Action</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="bg-light">
						<tr v-for="(agent, i) in agents" :key="i" v-if="agents.length">
							<td scope="row">{{agent.id}}</td>
							<td>{{agent.username}}</td>
							<td>{{agent.email}}</td>
							<td>{{agent.created_at}}</td>
							<td>{{agent.dateOfBirth}}</td>
							<td>{{agent.gender}}</td>
							<td>
								<Button type="info" size="small" @click="showagentEditModal(agent, i)">Edit</Button>								
							</td>
							<td>
								<router-link :to="'/agent/'+agent.id"><Button type="info" size="small">agent Profile</Button></router-link>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<Modal 
			v-model="editAgentModal"
			title="Edit agent Dialogue Box"
			:mask-closable='false'
			:closable='false'
			>			

			<div slot="header">
				<Button type="error" @click="editAgentModal=false">Close</Button>
				<Button type="info" @click='editagent'>Save Changes</Button>
				<p>Fill the form below to edit your agents data </p>
			</div>			
			
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">Salary</label>
				<div class="col-md-8">
					<input v-model="editData.salary" placeholder="How much are you paying monthly?" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">Gender</label>
				<div class="col-md-8">
					<RadioGroup v-model="editData.gender">
					    <Radio label="male">Male</Radio>
					    <Radio label="female">Female</Radio>
					</RadioGroup>					
				</div>
			</div>			
			<div slot="footer">
				Use the save button on top of this Window
			</div>

		</Modal>
		</div>
	</div>
</template>
<script>
export default {
	data(){
		return {
			data:{
				username:'',
				email:'',				
				dateOfBirth:'',				
				gender:'',
				salary:'',				

			},
			loading:false,			
			agents:[],
			editAgentModal:false,
			editData: {				
				gender:'',
				salary:'',	
			},
			index : 1,
		}
	},
	methods: {		
		async editagent(){
			if (this.editData.salary.trim()=='') {
				return this.e('Salary required')
			}			
			if (this.editData.gender.trim()=='') {
				return this.e('Gender is required')
			}
			
			const res= await this.callApi('post', '/landlord/editAgent', this.editData)
			if (res.status==200) {
				this.agents[this.index].salary = this.editData.salary
				this.agents[this.index].gender = this.editData.gender
				this.s('agent Data updated Successfully')
				this.editAgentModal=false				
			}else{
				if (res.status==422) {
					if (res.data.errors.salary) {
						this.e(res.data.errors.salary[0])
					}
					if (res.data.errors.gender) {
						this.e(res.data.errors.gender[0])
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
		showagentEditModal(agent, index){
			let object = {
				id: agent.id,
				salary : agent.salary,			 
				gender : agent.gender
			}

			this.editData = object
			this.editAgentModal = true
			this.index = index
		}

	},
	async created(){
		const res= await this.callApi('get', '/landlord/myagents')
		if (res.status === 200) {
			this.s('agents loaded Successfully')
			this.agents = res.data
		}
		else{
			this.e('Something went wrong while loading agents')
		}
	}
	
}
</script>