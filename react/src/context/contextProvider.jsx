import axios from "axios"
import { Children, createContext, useContext, useState } from "react"
export const StateContext = createContext({
 setUsers: ()=>{},
 user2:null
})


export const ContextProvider = ({children}) =>{
    const [user2,setUsers]= useState({});
    const [token,_setToken]=useState(localStorage.getItem("ACCESS_TOKEN"));

    const setToken= (token)=>{
        _setToken(token);
        if(token){
            localStorage.setItem("ACCESS_TOKEN",token);
            console.log("added")
        }else{
            localStorage.removeItem("ACCESS_TOKEN");
            console.log("removed")
        }
    }
    return (
        <StateContext.Provider value={{
            user2,
            setUsers,
            token,
            setToken
        }}>
            {children}
        </StateContext.Provider>
    )
}



export const useStateContext = ()=> useContext(StateContext);