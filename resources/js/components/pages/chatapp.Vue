<template>
	<div>
		<Row :gutter="16">
			<Col span="6">
				<contacts>
					
				</contacts>
			</Col>
			<Col span="18">
				<Card>
					<p slot="title">Conversation
					</p>
				</Card>
				<router-view>

				</router-view>
			</Col>
		</Row>
	</div>
</template>
<script>
import contacts from'./contacts.vue'
	export default {
		components:{contacts} 
	}
</script>