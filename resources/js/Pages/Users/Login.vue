<template>
    <div id="login">
        <img src="" alt="로고" class="logo">

        <form class="form type01" @submit.prevent="login" @keyup="form.clearErrors()">
            <div class="input-wrap mt-normal">
                <div class="input-text type01">
                    <input type="text" placeholder="이메일 아이디" v-model="form.email">
                </div>

                <p class="input-error type01" v-if="form.errors.email">{{ form.errors.email }}</p>
            </div>

            <div class="input-wrap mt-normal">
                <div class="input-text type01">
                    <input type="password" placeholder="비밀번호" v-model="form.password">
                </div>

                <p class="input-error type01" v-if="form.errors.password">{{ form.errors.password }}</p>
            </div>

            <div class="links">
                <Link href="/passwordResets/create" class="link">비밀번호 찾기</Link>
                <Link href="/users/create" class="link">회원가입</Link>
            </div>

            <button class="btn type01">로그인</button>
            <a href="/openLoginPop/naver" class="btn type01">네이버로 로그인</a>
            <a href="/openLoginPop/kakao" class="btn type01">카카오 로그인</a>
            <a href="/openLoginPop/google" class="btn type01">구글 로그인</a>
        </form>

    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue';

export default {
    components: {Link},
    data() {
        return {
            form: this.$inertia.form({
                email: null,
                password: null
            })
        }
    },

    methods: {
        login() {
            this.form.post("/login")
        }
    }
}
</script>
