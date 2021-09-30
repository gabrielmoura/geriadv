window.mclients = {
    get status() {
        return this.status
    },
    status: false,
    /**
     * Define Nota a cliente
     */
    setNote: function (note, clientID) {
        axios.post(location.protocol + '//' + location.host + '/ajax/setNote', {body: note, id: clientID})
            .then(response => {
                this.status = response.data;

            })
            .catch(err => {
                this.status = false;
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
    /**
     * Busca Notas do Cliente
     * @param clientID
     */
    getNote: function (clientID) {
        axios.post(location.protocol + '//' + location.host + '/ajax/getNote', {id: clientID})
            .then(response => {
                return response.data;
            })
            .catch(err => {
                this.status = false;
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
    /**
     * Busca Status
     * @param clientID
     */
    getStatus: function (clientID) {
        axios.post(location.protocol + '//' + location.host + '/ajax/getStatus', {id: clientID})
            .then(response => {
                return response.data;
            })
            .catch(err => {
                this.status = false;
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
    /**
     * Busca todos por status
     * @param status
     */
    getByStatus: function (status) {
        axios.post(location.protocol + '//' + location.host + '/ajax/getByStatus', {status: status})
            .then(response => {
                return response.data;
            })
            .catch(err => {
                this.status = false;
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
    /**
     * Define Status
     * @param clientID
     * @param status
     * @param functionaryID
     */
    setStatus: function (clientID, status, functionaryID) {
        axios.post(location.protocol + '//' + location.host + '/ajax/setStatus', {
            status: status,
            clientID: clientID,
            functionaryID: functionaryID
        })
            .then(response => {
                this.status = response.data;
            })
            .catch(err => {
                this.status = false;
            });
    },
    /**
     * Busca dependencias
     * @param clientID
     */
    getPendency: function (clientID) {
        axios.post(location.protocol + '//' + location.host + '/ajax/getPendency', {status: status, id: clientID})
            .then(response => {
                return response.data;
            })
            .catch(err => {
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
    /**
     * Busca agendamentos por data
     * @param date
     */
    getSheduled: function (date) {
        axios.post(location.protocol + '//' + location.host + '/ajax/getSheduled', {date: date})
            .then(response => {
                return response.data;
            })
            .catch(err => {
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
    /**
     * Busca Cep e salva em Cache
     * @param cep
     */
    getCep: function (cep) {

        axios.post(location.protocol + '//' + location.host + '/ajax/getCep', {cep: cep})
            .then(function (r) {
                if (process.env.NODE_ENV !== 'production') {
                    console.log(r.data);
                }
                document.getElementById('Street').value = r.data.logradouro;
                document.getElementById('City').value = r.data.localidade;
                document.getElementById('District').value = r.data.bairro;
                document.getElementById('State').value = r.data.uf;
            });
    },
    /**
     * Define Beneficio
     * @param name
     * @param description
     * @param clientID
     */
    setBenefit: function (name, description, clientID) {
        axios.post(location.protocol + '//' + location.host + '/ajax/setBenefit', {
            name: name,
            description: description,
            clientID: clientID
        })
            .then(response => {
                this.status = response.data;

            })
            .catch(err => {
                this.status = false;
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
    /**
     * Define Recomendações
     * @param name
     * @param clientID
     */
    setRecommendation: function (name, clientID) {
        axios.post(location.protocol + '//' + location.host + '/ajax/setRecommendation', {
            name: name,
            clientID: clientID
        })
            .then(response => {
                this.status = response.data;

            })
            .catch(err => {
                this.status = false;
                if (process.env.NODE_ENV !== 'production') {
                    console.log(err);
                }
            });
    },
}
