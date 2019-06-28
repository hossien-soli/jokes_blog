import React,{ Component } from "react";
import { BrowserRouter,Route,Switch } from "react-router-dom";

import Navigation from "./components/Navigation";
import Home from "./components/Home";
import Register from "./components/auth/Register";

class App extends Component {
    render () {
        return (
            <BrowserRouter>
                <div className="container-fluid" >
                    <Navigation />

                    <div className="main-content py-3" >
                        <Switch>
                            <Route exact path="/" component={Home} />
                            <Route path="/register" component={Register} />
                        </Switch>
                    </div>
                </div>
            </BrowserRouter>
        )
    }
}

export default App;