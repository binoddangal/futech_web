<template>
    <v-app>
        <div class=" ">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="text-center text-4xl font-extrabold text-gray-900">
                    Enter code
                </h2>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white sm:px-10">
                    <CodeInput :loading="false" class="input" v-on:change="onChange" v-on:complete="onComplete" />

                    <div>
                        Did not receive your code? Click here to resend
                    </div>

                </div>
            </div>
        </div>

        <v-dialog
            persistent
            v-model="loadDialog"
            width="300"
        >
            <v-card
                color="primary"
                dark
            >
                <v-card-text>
                   Please standby while we verify your detail
                    <v-progress-linear
                        class="mb-0"
                        color="white"
                        indeterminate
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
import CodeInput from "vue-verification-code-input";
export default {
    name: "MfaVerification",
    data(){
        return{
            loadDialog:true
        }
    },
    components: {
        CodeInput
    },
    methods: {
        onChange(v) {
            console.log("onChange ", v);
        },
        onComplete(v) {
            console.log("onComplete ", v);
        }
    }
};
</script>

<style scoped>

</style>
