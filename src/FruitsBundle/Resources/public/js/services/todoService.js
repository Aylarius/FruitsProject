function todoService($http) {

    this.$http = $http;

    this.create = (data) => {
        return this.$http.post('/fruits/new', {
            description: data
        })
    }

    this.getAll = () => {
        return this.$http.get('/fruits/')
    }

    this.getOne = (id) => {
        return this.$http.get('/fruits/' + id + '/show')
    }

    this.update = (id, data) => {
        return this.$http.put('/fruits/' + id + '/edit', {
            description: data
        })
    }

    this.delete = (id) => {
        return this.$http.delete('/fruits/' + id + '/delete')
    }

}
