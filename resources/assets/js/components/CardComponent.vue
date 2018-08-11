<template>
    <div>
        <div>
            <table class="table table-bordered table-hover">
                <tr>
                    <td>ID</td>
                    <td>商品图片</td>
                    <td>商品名称</td>
                    <td>商品单价</td>
                    <td>商品总价</td>
                    <td>商品数量</td>
                    <td>添加时间</td>
                    <td>操作</td>
                </tr>

                <tr v-for="card in this.cards">
                    <td>{{card.id}}</td>
                    <td><img :src="card.path" height="100"></td>
                    <td>{{card.name}}</td>
                    <td>{{card.price}}</td>
                    <td>{{card.num * card.price}}</td>
                    <td>{{card.num}}</td>
                    <td>{{card.created_at}}</td>
                    <td><button class="btn danger" v-on:click="del(card.id)" >删除</button></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                cards: [],
            };
        },
        created() {
            var that = this;
            axios.get(url).then(function (result) {
                that.cards = result.data.msg;
            });
        },
        computed: {

        },
        methods: {
            del: function (id) {
                confirm('确定要删除么');
                axios.get(del_url+'?id=' + id).then(function (result) {
                    if (!result.data.errcode) {
                        location.href='';
                    } else {
                        alert('购买失败')
                    }
                });
            }
        }
    };
</script>

