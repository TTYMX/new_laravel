<template>
    <div>
        这个是尾部
    </div>
</template>



<style lang="scss" scoped>
    #card_img {
        height: 500px;
    }
    .cartFooter {
        position: fixed;
        width: 100%;
        height: 1.18rem;
        font-size: 0.35rem;
        background: white;
        bottom: 0;
        display: block;
        border-top: 1px solid #f4f4f4;
    }
    .checkAll {
        width: 24%;
        line-height: 1.18rem;
        float: left;
    }
    .checkAll i {
        font-size: 0.53rem;
        padding-left: .5rem;
    }
    .Total {
        float: left;
        width: 35%;
        text-align: center;
        line-height: 1.18rem;
        font-size: 0.35rem;
    }
    .Settlement {
        width: 34%;
        height: 80%;
        background: #f81200;
        float: right;
        margin-top: .1rem;
        border-radius: 40px;
        margin-right: 0.3rem;
    }
    .Settlementtwo {
        width: 50%;
        height: 100%;
        background: #e3211e;
        float: right;
    }
    .Settlement a,
    .Settlementtwo a {
        color: white;
        text-align: center;
        line-height: .98rem;
        display: block;
        font-size: 0.35rem;
    }
</style>

