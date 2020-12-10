<template>
	<div>		
		<Row type="flex" justify="center">
			<Col span="20">
				<Form inline>
					<FormItem prop="query" label="Search locations or describe your prefereed house">
					    <Input type="text" v-model="query.query"  placeholder="prefered House">
					        <Icon type="md-search" slot="prepend"></Icon>
					    </Input>
					</FormItem>
					
					<!-- <FormItem prop="rent" label="Rent Amount">
					    <Input type="text" v-model="data.rent"  placeholder="Rent Amount">
					        <Icon type="ios-person-outline" slot="prepend"></Icon>
					    </Input>
					</FormItem>

					<FormItem prop="description" label="Descrition">
					    <Input type="text" v-model="data.description" >
					        <Icon type="ios-person-outline" slot="prepend"></Icon>
					    </Input> -->
					   
					</FormItem>	

					<FormItem>					   
					   <Button type="primary" shape="circle" @click="search"><Icon type="md-search"/></Button>
					</FormItem>		
				</Form>

				<Card>
					
					      <div v-for="(result, r) in results" :key="r" v-if="results.length" monitor-images-loaded>
					        <div class="card">
					        	<div class="card-header">
					        		<h5 class="text-center font-weight-bold">{{result.house_name}}
					        			<span class="float-right text-success font-weight-bold">{{result.rent_amount}} Monthly</span></h5>

					        	</div>
					        	<div class="card-body">
					        		<div class="row justify-content-center">

					        			<div class="col-md-4">
					        				<p>{{result.geo_location}} ; <br>
					        					{{result.status}} ; <br>
					        					{{result.rooms}} room(s)
					        				</p>
					        			</div>

					        			<div class="col-md-8">
					        				<span v-html="result.description">
					        				</span>
					        			</div>	

					        		</div>

					        	</div>

					        </div>
					      </div>
					    
				</Card>
			</Col>
		</Row>
	</div>
</template>
<script>
		export default{
			data(){
				return {
					query:{
						query:''
					},
					results:[]						
				}
			},
			methods:{
				async search(){
				if (this.query.query.trim()=='') {
					return this.e('Please  enter something in search')
				}									
					const res= await this.callApi('post', '/search/house', this.query)
					if (res.status==200) {
						this.s('Search complete')
						this.results = res.data
				 }
				}
			}	
		}
		
</script>