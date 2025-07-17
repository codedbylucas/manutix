 // Configurações globais Chart.js
        Chart.defaults.font.family = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.color = '#292b2c';

        // Gráfico de Pizza - Status dos Chamados
        fetch(baseUrl + '/grafico/status')
            .then(r => {
                if (!r.ok) throw new Error('Resposta não OK');
                return r.json();
            })
            .then(data => {
                const labels = data.map(item => item.status);
                const values = data.map(item => item.total);
                const colors = ['#007bff', '#dc3545', '#ffc107', '#28a745', '#6610f2', '#6c757d'];

                const ctx = document.getElementById("myPieChart");
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: colors.slice(0, values.length),
                        }],
                    },
                });
            })
            .catch(error => {
                console.error('Erro ao carregar dados do gráfico:', error);
            });


        // Gráfico de Barras - Chamados por Técnico
        fetch(baseUrl + '/grafico/tecnico')
            .then(r => {
                if (!r.ok) throw new Error('Resposta não OK');
                return r.json();
            })
            .then(data => {
                const labels = data.map(item => item.tecnico);
                const values = data.map(item => item.total);

                const ctx = document.getElementById("myBarChart");
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Chamados',
                            data: values,
                            backgroundColor: '#0d6efd',  // Azul Bootstrap
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: context => context.parsed.y + ' chamados'
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: { display: true, text: 'Técnico' }
                            },
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Quantidade de chamados' },
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Erro ao carregar dados do gráfico:', error);
            });