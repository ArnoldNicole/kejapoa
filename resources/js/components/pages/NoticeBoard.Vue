<template>
	<div>
		<Row :gutter="16">
		<Col span="6">
			<Button @click="fetchallNotifications" type="primary"><Icon type="md-add"></Icon> Load All Notifications</Button>
		</Col> 
			<Col span="18" offset="6">
			<Card>
				<div slot="title" class="text-dark text-capitalize font-weight-bold">
					KEJAPOA NOTIFICATIONS
				</div>
				<div v-for="(notification, n) in notifications" :key="n" v-if="notifications.length">
					<Alert type="info" show-icon closable>
					        {{notification.data.name}}
					        <span slot="close" @click="markAsRead(notification, n)">&times;</span>
					        <template slot="desc">
								{{notification.data.message}}
								<br>
								<a :href="'/chat/'+notification.data.id"><span>Inbox</span></a>
					         </template>
					    </Alert>
				</div>
			</Card>
		</Col>
		</Row>
	</div>
</template>
<script>
	 
		export default {
			data(){
				return {
					notifications:[],
					editData:[],
					
				}
			},
			methods:{
				async fetchallNotifications(){
					const resp = await this.callApi('get','/user/api/notifications/fetchallNotifications')
					this.notifications = resp.data
				},
				 async markAsRead(notification, index) {
				 	let object = {
				 		id: notification.id,				 		
				 	}
				 	this.editData = object
				 	const markAsReadStatus = await this.callApi('post','/user/api/notifications/markAsRead', this.editData)
				 	if (markAsReadStatus.status==200) {
				 		//remove the notification from the object

				 	}

				 }
			},
			async created(){
				const server_res = await this.callApi('get','/user/api/notifications/unread')
				this.notifications = server_res.data
			}
		}
</script>