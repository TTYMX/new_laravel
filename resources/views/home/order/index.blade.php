@include('/home/layout/top')
<h1>我的订单列表</h1>

<!-- DOM 视图 -->





<div class="content">
    <input v-model="newTodo" v-on:keyup.enter="addTodo">
    <ul>
        <li v-for="todo in todos">
            <span>@{{ todo.text }}</span>

        </li>
    </ul>
</div>

<script type="text/javascript">
    new Vue({
        el: '.content',
        data: {
            newTodo: '',
            todos: [
                { text: '新增todos' }
            ]
        },
        methods: {
            addTodo: function () {
                var text = this.newTodo.trim()
                if (text) {
                    this.todos.push({ text: text })
                    this.newTodo = ''
                }
            },
            removeTodo: function (index) {
                alert('ni');
                this.todos.splice(index, 1)
            }
        }
    })
</script>


@include('/home/layout/bottom')