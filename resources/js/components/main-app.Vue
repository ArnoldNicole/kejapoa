<template>
<div>
    <Menu mode="horizontal" :theme="theme1" active-name="1">
       
        <MenuItem name="1" to="/profile">
                <Icon type="ios-paper" />
                Home
        </MenuItem>
       
        <Submenu name="2" v-if="user.is_landlord">
            <template slot="title">
                <Icon type="ios-people" />
                Agents
            </template>
            <MenuGroup title="My Agents">
                <MenuItem name="2-1" to="/agents/create">Add</MenuItem>
                <MenuItem name="2-2" to="/agents/manage">View All</MenuItem>                
            </MenuGroup>            
        </Submenu>

        <Submenu name="3">
            <template slot="title">
                <Icon type="ios-stats" />
                Chats
            </template>
            <MenuGroup title="Messages">
                <MenuItem name="3-1">Inbox</MenuItem>
                <MenuItem name="3-2">Trash</MenuItem>                
            </MenuGroup>            
        </Submenu>

        <MenuItem name="4" to="/addHouses" v-if="user.is_landlord">           
            <Icon type="ios-construct" />
            Houses
         </Icon>       
        </MenuItem>

    </Menu>  

    <Row>
        <Col span="24" justify="center" >
            <Card>
                <div slot="title">
                    <RadioGroup v-model="theme1">
                        <Radio label="light"></Radio>
                        <Radio label="dark"></Radio>
                        <Radio label="primary"></Radio>
                    </RadioGroup>
                </div>
                <router-view></router-view>                
            </Card>
        </Col>        
    </Row> 

</div>
</template>
<script>
    export default {
        data () {
            return {
                theme1: 'light',
                user:[],
            }
        },
        async created(){
            const res= await this.callApi('get', '/user')
            if (res.status === 200) {                
                this.user = res.data
            }
            else{
                this.e('Unexpected error keeps on occuring')
            }
        }
    }
</script>