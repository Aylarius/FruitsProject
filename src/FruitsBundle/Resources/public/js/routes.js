const routes = ($routeProvider, $httpProvider, $locationProvider) => {
    $locationProvider.html5Mode(false).hashPrefix('');
    $routeProvider
        .when('/', {
            templateUrl: '../bundles/fruits/views/main.html',
            controller: 'mainController',
            controllerAs: 'vm',
            resolve: {
                connected: checkIsConnected
            }
        })
        .when('/login', {
            templateUrl: '../bundles/fruits/views/login.html',
            controller: 'loginController',
            controllerAs: 'vm'
        })
        .otherwise({
            redirectTo: '/'
        })

    $httpProvider.interceptors.push(($q, $location, $rootScope, $window, sessionFactory) => {
        return {
            request(config) {

                config.headers = config.headers || {};
                if ($window.localStorage.token) {
                    sessionFactory.token = $window.localStorage.token
                    config.headers.authorization = $window.localStorage.token
                }
                return config
            },
            responseError(response) {
                if (response.status === 401 || response.status === 403) {
                    $rootScope.$emit('loginStatusChanged', false);
                    $location.path('/~thifainenoirault/Fruits/web/app_dev.php/user/login')
                }
                return $q.reject(response)
            }
        }
    })

}

const loginStatus = ($rootScope, $window, sessionFactory) => {

    $rootScope.$on('loginStatusChanged', (event, isLogged) => {
        $window.localStorage.token = sessionFactory.token;
        sessionFactory.isLogged = isLogged;
    })

}

const checkIsConnected = ($q, $http, $location, $window, $rootScope) => {
    let deferred = $q.defer()

    $http.get('/~thifainenoirault/Fruits/web/app_dev.php/user/loggedin').success(() => {
        $rootScope.$emit('loginStatusChanged', true);
        // Authenticated
        deferred.resolve()
    }).error(() => {
        $window.localStorage.removeItem('token');
        $rootScope.$emit('loginStatusChanged', false);
        // Not Authenticated
        deferred.reject()
        $location.url('/~thifainenoirault/Fruits/web/app_dev.php/user/login')
    })

    return deferred.promise
}
