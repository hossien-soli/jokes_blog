import React,{ Component } from "react";
import Axios from "axios";
import config from "../../config";

class Dashboard extends Component {

    constructor (props) {
        super(props);

        this.state = {
            apiToken: '',
            userInfo: '',
            error: false,
        };
    }

    componentDidMount () {
        const apiToken = localStorage.getItem('api_token');
        if (!apiToken) {
            this.props.history.push('/login');
            return 0;
        }
        
        this.setState({apiToken});

        const query = `api_token=${apiToken}`;
        Axios.get(`${config.app.serverUrl}/user?${query}`)
            .then(resp => {
                const data = resp.data;
                if (data.ok) {
                    const userInfo = data.user;
                    this.setState({userInfo});
                }
                else {
                    this.setState({error: true});
                    localStorage.removeItem('api_token');
                    this.props.history.push('/login');
                }
            }).catch(err => {
                this.setState({error: true});
            });
    }

    render () {
        return (
            <div>
                { !this.state.userInfo ? (
                    <div>
                        { this.state.error ? (
                            <h2 className="text-danger" >Ops | Error while loading informations !</h2>
                        ) : (
                            <h2>Loading informations ...</h2>
                        )}
                    </div>
                ) : (
                    <div>
                        <h2>User : {this.state.userInfo.name}</h2>
                        <hr/>
                        <div className="card" >
                            <div className="card-header" >
                                <h3>Your Jokes</h3>
                            </div>
                            <div className="card-body" >
                                
                            </div>
                        </div>
                    </div>
                )}
            </div>
        );
    }
}

export default Dashboard;