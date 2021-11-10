// App.vue

<template>
    <div class="">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="container">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">Home page</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/create_products" class="nav-link">New product</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/products" class="nav-link">All product</router-link>
                    </li>
                </ul>
            </div>
        </nav>
        <br/>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>