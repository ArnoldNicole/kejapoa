<template>
	<div>
		<Card>
			<p slot="title">Contacts
				<a :href="/profile/" class="float-right">
					<span>
					<Icon type="ios-home-outline" size="30"></Icon>
				</span>
				</a>
			</p>
			<Row>
				<Col span="24">
			<div v-for="contact in contacts">
				<a :href="'/chat/'+contact.id">
					<div class="row justify-content-center mb-1">
						<div class="col-md-4">
							<img v-bind:src="contact.profile_image" v-bind:alt=" contact.profile_image" class="w-50 rounded-circle">
						</div>
						<div class="col-md-8">
							<h5 class="text-md-left">{{contact.name}}</h5>
						</div>
					</div>
				</a>
			</div>
			</Col>
			</Row>
		</Card>
	</div>
</template>
<script>
	export default {		
		data(){
			return {
				contacts:[],
			}
		},
		async created(){
			const responseFromServer = await this.callApi('get','/user/fetchContactData')
			if (responseFromServer.status==200) {
				this.s('Contacts loaded')
				this.contacts = responseFromServer.data
			}else{
				this.swr()				
			}
		}
	}
</script>