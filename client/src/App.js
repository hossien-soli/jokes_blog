import React,{ Component } from "react";
import { BrowserRouter,Route,Switch } from "react-router-dom";

import Navigation from "./components/Navigation";
import Home from "./components/Home";
import Register from "./components/auth/Register";
import Login from "./components/auth/Login";
import Dashboard from "./components/auth/Dashboard";

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
                            <Route path="/login" component={Login} />
                            <Route path="/dashboard" component={Dashboard} />
                        </Switch>
                    </div>
                </div>
            </BrowserRouter>
        )
    }
}

export default App;