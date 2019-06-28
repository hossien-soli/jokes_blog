import React,{ Component } from "react";

import Counter from "./others/Counter";

class Home extends Component {

    componentDidMount () {
        document.title = "Home";
    }

    render () {
        return (
            <div>
                <h2 className="text-primary" >You're at Home !</h2>
                <br/>
                <Counter />
            </div>
        );
    }
}

export default Home;