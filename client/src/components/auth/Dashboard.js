import React,{ Component } from "react";

class Dashboard extends Component {

    constructor (props) {
        super(props);

        this.state = {
            apiToken: '',
        };
    }

    componentDidMount () {
        const apiToken = localStorage.getItem('api_token');
        this.setState({apiToken});
    }

    render () {
        return (
            <div>
                <h2>Your Dashboard !</h2>
            </div>
        );
    }
}

export default Dashboard;