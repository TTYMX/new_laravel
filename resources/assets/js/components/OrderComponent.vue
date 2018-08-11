<template>
    <div>
        <div>
            <table class="table table-bordered table-hover">
                <tr>
                    <th width="15%">订单号</th>
                    <th>价格</th>
                    <th>支付时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>

                <tr v-for="order in this.orders">
                    <td >{{order.order_num}}</td>
                    <td>{{order.price}}</td>
                    <td>{{order.created_at}}</td>
                    <td v-if="order.status == 1">已支付,待发货</td>
                    <td v-else-if="order.status == 2">已发货</td>
                    <td v-else>待支付</td>
                    <td v-bind:onclick="jumping('/home/order/ping?id='+order.id)">评论</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['ping'],
        data() {
            return {
                orders: [],
            };
        },
        created() {
            var that = this;
            axios.get(url).then(function (result) {
                that.orders = result.data.msg;
            });
        },
        computed: {
        },
        methods: {
            jumping:function (url) {
                console.log(url);
                location.href = url;
            }
        }
    };
</script>

