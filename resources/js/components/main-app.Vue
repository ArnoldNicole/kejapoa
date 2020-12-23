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
                Chat and Notices
            </template>
            <MenuGroup title="Messages">
                <MenuItem name="3-1" to="/chats">Contacts</MenuItem>
                <MenuItem name="3-2" to="/notifications">Notice Board</MenuItem>                
            </MenuGroup>            
        </Submenu>

        <MenuItem name="4" to="/addHouses" v-if="user.is_landlord">           
            <Icon type="ios-construct" />
            Houses
         </Icon>       
        </MenuItem>

    </Menu>  

    <Row :gutter="16">
        <Col span="18" justify="center" >
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
        <Col span="6">

            <Card class="mt-2">
                <Alert type="info" show-icon closable>                       
                        <span slot="close">&times;</span>
                        <template slot="desc">
                           
                            <router-link to="/notifications/">
                                <span class="badge badge-info">{{user.notesCount}} </span> Unread Notifications
                            </router-link>
                          
                         </template>
                    </Alert>
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
            const res= await this.callApi('get', '/user/profileData')
            if (res.status == 200) {                
                this.user = res.data.data
            }
            else{
                this.e('Unexpected error keeps on occuring')
            }
        }
    }
</script>