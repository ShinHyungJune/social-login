<template>
    <div id="create-user">
        <img src="" alt="로고" class="logo">

        <form class="form type01" @submit.prevent="submit" @keyup="form.clearErrors()">
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

            <div class="input-wrap mt-normal">
                <div class="input-text type01">
                    <input type="password" placeholder="비밀번호 확인" v-model="form.password_confirmation">
                </div>

                <p class="input-error type01" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</p>
            </div>

            <button class="btn type01">비밀번호 초기화</button>
        </form>

    </div>
</template>
<script>
export default {
    data() {
        return {
            form: this.$inertia.form({
                email: null,
                password: null,
                password_confirmation: null,
                token: location.pathname.split("/")[2]
            })
        }
    },

    methods: {
        submit() {
            this.form.patch("/passwordResets/" + this.form.token,{
                onSuccess: (response) => {
                    alert(response.props.message);
                }
            });
        },
    }
}
</script>
