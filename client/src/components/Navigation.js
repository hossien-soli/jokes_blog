import React from "react";
import { NavLink,Link } from "react-router-dom";

function Navigation (props) {
    return (
        <nav className="navbar navbar-expand-md navbar-dark bg-dark" >
            <Link to="/" className="navbar-brand" >Jokes Blog</Link>
            
            <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu">
                <span clss="navbar-toggler-icon"></span>
            </button>

            <div className="collapse navbar-collapse" id="mainMenu">
                <ul className="navbar-nav">
                    <li className="nav-item">
                        <NavLink exact to="/" className="nav-link" >Home</NavLink>
                    </li>
                    <li className="nav-item">
                        <a className="nav-link" href="#">Jokes</a>
                    </li>
                    <li className="nav-item">
                        <NavLink to="/register" className="nav-link" >Register</NavLink>
                    </li>
                    <li className="nav-item" >
                        <a className="nav-link" href="#" >Login</a>
                    </li>
                </ul>
            </div> 
        </nav>
    )
}

export default Navigation;