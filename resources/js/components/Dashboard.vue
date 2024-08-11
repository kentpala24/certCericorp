<template>
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Escritorio</a> </li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Certificates</h4>
                            </div>
                            <div class="card-content">
                                <canvas id="certificates">

                                </canvas>
                                <div class="card-footer">
                                    <p>Certificates of the Last Months</p>
                                </div>
                            </div>
                            <div class="card-header">
                                <h4>Canceled</h4>
                            </div>
                            <div class="card-content">
                                <canvas id="anuladoss">

                                </canvas>
                                <div class="card-footer">
                                    <p>Voided Certificates</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
    
</template>
<script>
export default {
    data (){
        return{
            varCertificados:null,
            charCertificados:null,
            certificados:[],
            varTotalCertificados:[],
            varMesCertificados:[],
            
            varanulados:null,
            charanulados:null,
            anulados:[],
            varTotalanulados:[],
            varMesanulados:[],
        }
    },
    methods : {
        getCertificados(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.certificados = respuesta.certificados;
                    me.loadCertificados();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
        loadCertificados(){
            let me=this;
            me.certificados.map(function(x){
                me.varMesCertificados.push(x.mes);
                me.varTotalCertificados.push(x.total)
            });
            me.varCertificados=document.getElementById('certificates').getContext('2d');
            me.charCertificados = new Chart(me.varCertificados, {
                type: 'bar',
                data: {
                    labels: me.varMesCertificados,
                    datasets: [{
                        label: 'Certificates',
                        data: me.varTotalCertificados,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        getCertificadosA(){
            let me=this;
            var url='/dashboard';
            axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.anulados = respuesta.anulados;
                    me.loadCertificadosA();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
        loadCertificadosA(){
            let me=this;
            me.anulados.map(function(x){
                me.varMesanulados.push(x.mesa);
                me.varTotalanulados.push(x.totala)
            });
            me.varanulados=document.getElementById('anuladoss').getContext('2d');
            me.charanulados = new Chart(me.varanulados, {
                type: 'bar',
                data: {
                    labels: me.varMesanulados,
                    datasets: [{
                        label: 'Voided',
                        data: me.varTotalanulados,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    },
    
    mounted(){
        this.getCertificados();
        this.getCertificadosA();
    }
}
</script>