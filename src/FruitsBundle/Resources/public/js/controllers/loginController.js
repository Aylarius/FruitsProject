function loginController(userService, sessionFactory, $timeout, $location, $rootScope) {

    this.userService = userService;
    this.sessionFactory = sessionFactory;
    this.$timeout = $timeout;
    this.$location = $location;
    this.$rootScope = $rootScope;

    this.login = () => {
        this.userService.connect({
            username: this.username,
            password: this.password
        }).then((res) => {
            console.log(1,res);
            this.sessionFactory.token = res.data.token;
            this.sessionFactory.isLogged = true;
            this.$rootScope.$emit('loginStatusChanged', true);
            this.loginMessage = null;
            this.$location.path('/');
        }).catch((res) => {
            console.log(2,res);
            this.sessionFactory.isLogged = false;
            this.$rootScope.$emit('loginStatusChanged', false);
            this.loginMessage = {};
            this.loginMessage.type = "error";
            this.loginMessage.title = "Sign in error";
            this.loginMessage.message = "Error login or password";
        });
    };

    this.createAccount = () => {
        this.userService.create({
            username: this.username,
            password: this.password
        }).then((res) => {
            this.sessionFactory.token = res.data.token;
            this.sessionFactory.isLogged = true;
            this.$rootScope.$emit('loginStatusChanged', true);
            this.loginMessage = {};
            this.loginMessage.type = "success";
            this.loginMessage.title = "Account created !";
            this.loginMessage.message = "Redirecting...";
            this.$timeout(() => {
                this.loginMessage = null;
                this.$location.path('/');
            }, 2000);
        }).catch((res) => {
            this.sessionFactory.isLogged = false;
            this.$rootScope.$emit('loginStatusChanged', false);
            this.loginMessage = {};
            this.loginMessage.type = "error";
            this.loginMessage.title = "Sign up error";
            this.loginMessage.message = res.data;
        });
    };

}
