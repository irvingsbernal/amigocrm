<template>
    <main class="main">
        <qrcode-vue :value="idCita" size="100" foreground="#9ca9d3" level="H"></qrcode-vue>
    </main>
</template>
<script>
    import VueBarcode from 'vue-barcode';
    import QrcodeVue from 'qrcode.vue';
    export default {
        data (){
            return {
                idCita: this.$attrs.id,
            }
        },
        components: {
        QrcodeVue,
        }
    }
</script>