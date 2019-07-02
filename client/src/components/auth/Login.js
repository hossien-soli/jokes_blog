import React,{ Component } from "react";
import Axios from "axios";
import config from "../../config";
import Swal from "sweetalert2";

class Login extends Component {

    constructor (props) {
        super(props);

        this.state = {
            username: '',
            password: '',
        };

        this.getInputValue = this.getInputValue.bind(this);
        this.handleFormSubmit = this.handleFormSubmit.bind(this);
    }

    componentDidMount() {
        document.title = "Login to your Account";
    }

    getInputValue (e) {
        this.setState({
            [e.target.name]: e.target.value,
        });
    }

    handleFormSubmit (e) {
        e.preventDefault();

        const formData = new FormData ();
        formData.append('username',this.state.username.toString().trim());
        formData.append('password',this.state.password.toString().trim());
        
        // connect to the server
    }

    render () {
        return (
            <div className="card" >
                <div className="card-header" >
                    <h2>Login</h2>
                </div>
                <div className="card-body" >
                    <form onSubmit={this.handleFormSubmit} >
                        <div className="row" >
                            <div className="col-md-6" >
                                <div className="form-group" >
                                    <label htmlFor="username" >Username or Email</label>
                                    <input 
                                        type="text"
                                        name="username"
                                        autoFocus 
                                        value={this.state.username}
                                        id="username" 
                                        className="form-control"
                                        placeholder="Enter your username or email here ..."
                                        onChange={this.getInputValue} />
                                </div>
                                <div className="form-group" >
                                    <label htmlFor="password" >Password</label>
                                    <input 
                                        type="password"
                                        name="password" 
                                        value={this.state.password}
                                        id="password" 
                                        className="form-control"
                                        placeholder="Enter your password here ..."
                                        onChange={this.getInputValue} />
                                </div>
                                
                                <button 
                                    type="submit" 
                                    className="btn btn-primary" 
                                    style={{ width:180 }} >Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        );
    }
}

export default Login;