<template>
    <div>
        <div>
            <table class="table table-bordered table-hover">
                <tr>
                    <td>ID</td>
                    <td>商品图片</td>
                    <td>商品名称</td>
                    <td>商品单价</td>
                    <td>添加时间</td>
                    <td>操作</td>
                </tr>

                <tr v-for="card in this.cards">
                    <td>{{card.id}}</td>
                    <td><img :src="card.path" height="100"></td>
                    <td>{{card.name}}</td>
                    <td>{{card.price}}</td>
                    <td>{{card.created_at}}</td>
                    <td><a :href="card.id">删除</a></td>
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

        }
    };
</script>

