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
        return this.$http.get('/fruits/show/' + id)
    }

    this.update = (id, data) => {
        return this.$http.put('/fruits/edit/' + id, {
            description: data
        })
    }

    this.delete = (id) => {
        return this.$http.delete('/fruits/delete/' + id)
    }

}
