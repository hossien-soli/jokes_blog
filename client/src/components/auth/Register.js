import React,{ Component } from "react";
import Axios from "axios";
import Swal from "sweetalert2";
import config from "../../config";

class Register extends Component {

    constructor (props) {
        super(props);

        this.state = {
            name: '',
            email: '',
            username: '',
            password: '',
            passwordConfirm: '',
            avatar: null,
        };

        this.getInputValue = this.getInputValue.bind(this);
        this.handleAvatarChange = this.handleAvatarChange.bind(this);
        this.handleFormSubmit = this.handleFormSubmit.bind(this);
    }

    componentDidMount () {
        document.title = "Create new Account";
    }

    getInputValue (e) {
        this.setState({
            [e.target.name]: e.target.value,
        });
    }

    handleAvatarChange (e) {
        const avatar = e.target.files[0];
        this.setState({avatar});
    }

    handleFormSubmit (e) {
        e.preventDefault();
        
        const formData = new FormData ();
        formData.append('name',this.state.name.toString().trim());
        formData.append('email',this.state.email.toString().trim());
        formData.append('username',this.state.username.toString().trim());
        formData.append('password',this.state.password.toString().trim());
        formData.append('password_confirm',this.state.passwordConfirm.toString().trim());
        formData.append('avatar',this.state.avatar);

        Axios.post(`${config.app.serverUrl}/register`,formData,{
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        }).then(resp => {
            const data = resp.data;
            if (data.ok) {
                Swal.fire('Process Successful !','You have been registered !','success');
                this.setState({
                    name: '',
                    email: '',
                    username: '',
                    password: '',
                    passwordConfirm: '',
                    avatar: null,
                });
            }
            else {
                const errors = data.errors;
                const errorsText = '';
                for (var i in errors)
                    errorsText += errors[i] + '<br/>';
                Swal.fire('Some error are found !',errorsText,'warning');
            }
        }).catch(err => {
            Swal.fire('Ops !','Internal server error !<br/>Please try again later.','error');
        });
    }

    render () {
        return (
            <div className="card" >
                <div className="card-header" >
                    <h2>Create new Account</h2>
                </div>
                <div className="card-body" >
                    <form onSubmit={this.handleFormSubmit} onReset={e => e.target.elements[0].focus()} >
                        <div className="row" >
                            <div className="col-md-6" >
                                <div className="form-group" >
                                    <label htmlFor="name" >Name</label>
                                    <input 
                                        autoFocus
                                        id="name"
                                        type="text"
                                        name="name"
                                        value={this.state.name}
                                        className="form-control"
                                        placeholder="Enter your name ..."
                                        onChange={this.getInputValue} />
                                </div>
                                <div className="form-group" >
                                    <label htmlFor="email" >Email</label>
                                    <input 
                                        type="text"
                                        name="email"
                                        value={this.state.email}
                                        id="email" 
                                        className="form-control" 
                                        placeholder="Enter your email ..." 
                                        onChange={this.getInputValue} />
                                </div>
                                <div className="form-group" >
                                    <label htmlFor="username" >Username</label>
                                    <input 
                                        type="text"
                                        name="username"
                                        value={this.state.username}
                                        id="username" 
                                        className="form-control" 
                                        placeholder="Enter a username ..." 
                                        onChange={this.getInputValue} />
                                </div>
                            </div>
                            <div className="col-md-6" >
                                <div className="form-group" >
                                    <label htmlFor="password" >Password</label>
                                    <input 
                                        type="password"
                                        name="password"
                                        value={this.state.password}
                                        id="password" 
                                        className="form-control" 
                                        placeholder="Enter a password ..." 
                                        onChange={this.getInputValue} />
                                </div>
                                <div className="form-group" >
                                    <label htmlFor="passwordConfirm" >Password Confirm</label>
                                    <input 
                                        type="password"
                                        name="passwordConfirm" 
                                        value={this.state.passwordConfirm}
                                        id="passwordConfirm" 
                                        className="form-control" 
                                        placeholder="Enter password confirm ..." 
                                        onChange={this.getInputValue} />
                                </div>
                                <div className="form-group" >
                                    <label htmlFor="avatar" >Profile Picture</label>
                                    <div className="custom-file" >
                                        <label className="custom-file-label" htmlFor="avatar" >Choose a picture ...</label>
                                        <input 
                                            type="file" 
                                            className="custom-file-input" 
                                            id="avatar" 
                                            onChange={this.handleAvatarChange} />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="row" >
                            <div className="col-md-6" >
                                <button type="submit" className="btn btn-primary" >Create My Account</button>
                                <button type="reset" className="btn btn-danger ml-1" >Reset Form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        )
    }
}

export default Register;