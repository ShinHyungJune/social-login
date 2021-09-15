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

            <button class="btn type01">비밀번호 초기화 메일 발송</button>
        </form>

    </div>
</template>
<script>
export default {
    data() {
        return {
            form: this.$inertia.form({
                email: null,
            })
        }
    },

    methods: {
        submit() {
            this.form.post("/passwordResets",{
                onSuccess: (response) => {
                    alert(response.props.message);
                }
            });
        }
    }
}
</script>
