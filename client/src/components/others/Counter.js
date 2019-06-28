import React,{ useState } from "react";

function Counter () {
    const [count,setCount] = useState(0);

    return (
        <div className="d-inline-block border p-3 shadow" >
            <h2 className="text-danger" >Count : {count}</h2>
            <hr/>
            <button className="btn btn-danger" onClick={() => setCount(count+1)} >Click me !</button>     
        </div>
    );
}

export default Counter;