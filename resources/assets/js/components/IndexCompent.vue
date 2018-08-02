<template>
    <div>
        <div class="box" v-for="good in this.goods">
            <div v-on:click="jump(good.id)" class="a">
                <img height="200" :src="good.path">
            </div>
            <div>
                <h3>价格:{{good.price}}</h3>
                <h3>名称:{{good.name}}</h3>
                <h3>描述:{{good.content}}</h3>
                <h3>库存:
                    <div v-if="good.total<=0">
                        <span style="color:red;">{{good.total}}</span>
                    </div>
                    <div v-else>
                        <span style="color:blue;">{{good.total}}</span>
                    </div>
                </h3>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                goods: [],
                total:true,
            };
        },
        created() {
            var that = this;
            axios.get(url).then(function (result) {
                console.log(result.data);
                that.goods = result.data.msg;
            });
        },
        computed: {

        },
        methods: {
            jump:function(id){
                location.href = detail_url+'?id='+id;
            }
        }
    };
</script>

