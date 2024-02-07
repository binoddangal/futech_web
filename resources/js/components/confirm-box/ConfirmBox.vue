<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            persistent
            max-width="390"
        >

            <v-card>
                <v-card-title class="text-h6 text-center">
                    {{title}}
                </v-card-title>
                <v-card-text>{{message}}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red text-"
                        text
                        border
                        class="text-capitalize"
                        @click="_cancel()"
                    >
                        {{cancel_btn_text}}
                    </v-btn>
                    <v-btn
                        color="green"
                        text
                        border
                        class="text-capitalize"
                        @click="_confirm()"
                    >
                        {{ok_btn_text}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
 export default {
     data () {
         return {
             title:'User confirmation',
             message:'Are you sure ? Press Ok to confirm or Cancel to abort.',
             ok_btn_text:'Ok',
             cancel_btn_text:'Cancel',
             dialog: false,

             resolvePromise: undefined,
             rejectPromise: undefined,
         }
     },

     methods:{
         confirm(data)
         {
             this.dialog=true;
             this.title = data.title!=null?data.title:this.title;
             this.message =  data.message!=null?data.message:this.message;
             this.ok_btn_text = data.ok_btn_text!=null?data.ok_btn_text:this.ok_btn_text;
             this.cancel_btn_text = data.cancel_btn_text!=null?data.cancel_btn_text:this.cancel_btn_text;

             return new Promise((resolve, reject) => {
                 this.resolvePromise = resolve
                 this.rejectPromise = reject
             })
         },

         _confirm() {
             this.dialog = false;
             this.resolvePromise(true)
         },

         _cancel() {
             this.dialog = false;
             this.resolvePromise(false)

     }
     }
 }
</script>
