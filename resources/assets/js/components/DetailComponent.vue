<template>
    <div>
        <img height="200" :src="good.path">
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
        <button type="button" v-on:click="buy(good.total,good.id,0)" class="btn me btn-warning">加入购物车</button>
        <button type="button" v-on:click="buy(good.total,good.id,1)" class="btn me btn-success">立即购买</button>
        <button class="btn" type="button" v-on:click="jump('/home/card/list')">前往购物车</button>
        <button class="btn" type="button" v-on:click="jump('/home/order/buyList')">前往我的订单</button>
    </div>
</template>

<script>
    prop('id');
    export default {
        data() {
            return {
                good: [],
                total: true,
            };
        },
        created() {
            var that = this;
            axios.get(url).then(function (result) {
                console.log(result.data.msg)
                that.good = result.data.msg.good;
                that.good.path = result.data.msg.pic.path;

            });
        },
        computed: {},
        methods: {
            buy: function (total, id, $buy) {
                if (total > 0) {
                    console.log($buy);
                    if ($buy) {
                        //执行购买操作
                        axios.get(buy_url + '?id=' + id).then(function (result) {
                            if (!result.data.errcode) {
                                alert(result.data.errcode.msg)
                            } else {
                                alert('购买失败')
                            }
                        });
                    } else {
                        //执行添加购物车操作
                        axios.get(card_url).then(function (result) {
                            console.log(result.data);
                            that.goods = result.data.msg.data;
                        });
                    }
                } else {
                    alert('卖完了');
                }

            },
            jump:function (url) {
                location.href = url;
            }
        }
    }
</script>

