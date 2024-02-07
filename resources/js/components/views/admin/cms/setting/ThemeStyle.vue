<template>
      <v-card flat>
            <v-card-text>
                <div class="row">
                    <v-col cols="12" class="text-right">
                        <v-btn  outlined color="red" @click="resetColors()">Reset theme colors</v-btn>
                    </v-col>
                    <v-tabs vertical class="justify-start">

                        <v-tab class="justify-start">
                            Login screen
                        </v-tab>
                        <v-tab class="justify-start">
                            App sidebar
                        </v-tab>
                        <v-tab class="justify-start">
                            App header
                        </v-tab>
                        <v-tab class="justify-start">
                            Button color
                        </v-tab>

                        <v-tab-item>
                            <v-card>
                                <v-card-text>
                                    <div class="row pa-6">
                                        <div class="col-12 form-group">
                                            <label>Background image</label>
                                            <v-file-input
                                                    v-model="setting.login_bg_image_file"
                                                    prepend-icon=""
                                                    prepend-inner-icon="mdi-file"
                                                    placeholder="Choose a file or drop it here..."
                                                    outlined
                                                    dense
                                            ></v-file-input>

                                            <img
                                                v-if="setting.login_bg_path && setting.login_bg_path['real']"
                                                style="height:100px"
                                                :src="setting.login_bg_path['real']"
                                                alt
                                                class="mt-5"
                                            />
                                        </div>
                                        <div class="col-4 mt-2 form-group">
                                            <label>Background color</label><br/>
                                            <verte
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.login.bg_color"
                                            ></verte>

                                        </div>
                                        <div class="col-4 form-group">
                                            <label>College name color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.login.primary_color"
                                            ></verte>

                                        </div>

                                        <div class="col-4 form-group">
                                            <label>Slogan color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.login.secondary_color"
                                            ></verte>

                                        </div>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card>
                                <v-card-text>

                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label>Background color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.side_bar.primary_color"
                                            ></verte>

                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Text color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.side_bar.primary_text_color"
                                            ></verte>

                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Active menu background</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.side_bar.secondary_color"
                                            ></verte>

                                        </div>


                                        <div class="col-6 form-group">
                                            <label>Active menu text color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.side_bar.secondary_text_color"
                                            ></verte>


                                        </div>

                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card flat>
                                <v-card-text>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label>Background color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.header.primary_color"
                                            ></verte>

                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Menu text color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.header.primary_text_color"
                                            ></verte>

                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Active menu background</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.header.secondary_color"
                                            ></verte>

                                        </div>


                                        <div class="col-6 form-group">
                                            <label>Active menu text color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.header.secondary_text_color"
                                            ></verte>


                                        </div>

                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card flat>
                                <v-card-text>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label>Background color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.button.primary_color"
                                            ></verte>

                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Menu text color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.button.primary_text_color"
                                            ></verte>

                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Active menu background</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.button.secondary_color"
                                            ></verte>

                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Active menu text color</label><br/>
                                            <verte
                                                    @input="setStyleVariable"
                                                    menuPosition="bottom"
                                                    model="hex"
                                                    v-model="colors_variables.button.secondary_text_color"
                                            ></verte>


                                        </div>

                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                    </v-tabs>


                </div>
            </v-card-text>
        </v-card>
</template>

<script>
export default {
    name: "ThemeStyle",
    props: ["setting", "colors_variables"],
    methods: {
        setStyleVariable() {

            document.documentElement.style.setProperty('--sidebar-primary-color', this.colors_variables.side_bar.primary_color);
            document.documentElement.style.setProperty('--sidebar-secondary-color', this.colors_variables.side_bar.secondary_color);
            document.documentElement.style.setProperty('--sidebar-primary-text-color', this.colors_variables.side_bar.primary_text_color);
            document.documentElement.style.setProperty('--sidebar-secondary-text-color', this.colors_variables.side_bar.secondary_text_color);

            document.documentElement.style.setProperty('--header-primary-color', this.colors_variables.header.primary_color);
            document.documentElement.style.setProperty('--header-secondary-color', this.colors_variables.header.secondary_color);
            document.documentElement.style.setProperty('--header-primary-text-color', this.colors_variables.header.primary_text_color);
            document.documentElement.style.setProperty('--header-secondary-text-color', this.colors_variables.header.secondary_text_color);


            document.documentElement.style.setProperty('--button-primary-color', this.colors_variables.button.primary_color);
            document.documentElement.style.setProperty('--button-secondary-color', this.colors_variables.button.secondary_color);
            document.documentElement.style.setProperty('--button-primary-text-color', this.colors_variables.button.primary_text_color);
            document.documentElement.style.setProperty('--button-secondary-text-color', this.colors_variables.button.secondary_text_color);
        },
        resetColors(){
            this.$confirm({
                message: `Are you sure you want Restore Default Theme?`,
                button: {
                    no: "No",
                    yes: "Yes"
                },
                callback: confirm => {
                    if (confirm) {
                        this.$emit('reset_theme');
                    }
                }
            });

        }
    },
}
</script>

