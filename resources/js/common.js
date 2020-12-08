export default {
    data(){
        return {

        }
    }, 
    methods: {
        async callApi(method, url, dataObj ){
            try {
              return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }
        }, 

        i(desc, title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc,
                top: 50,
            });
        },
        s(desc, title="Great!") {
            this.$Notice.success({
                title: title,
                desc: desc,
                top: 50,
            });
        },
        w(desc, title="Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc,
                top: 50,
            });
        },
        e(desc, title="Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc,
                top: 50,
            });
        }, 
        swr(desc='Something went wrong! Please try again.', title="Oops") {
            this.$Notice.error({
                title: title,
                desc: desc,
                top: 50,
            });
        }
}
}