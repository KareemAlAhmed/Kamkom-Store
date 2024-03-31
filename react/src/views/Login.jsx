import axios from 'axios';
import React,{useEffect,useRef,useState} from "react"
import "./login.css"
import { useStateContext } from '../context/contextProvider';

export default function Login() {
  var [countries,setCountries]=useState([]);
  const [user,setUser]=useState({
    firstName:"",secondName:"",bio:"",email:"",password:"",mobile_number:0,
    country:"",streetAddress:"",province:"",city:"",zipcode:"",ship_to:"",
    currency:"",image_url:"",company_name:"null",company_business:"null"
  });
  
    const {setUsers,setToken,user2}=useStateContext();
        useEffect(()=>{axios.get("http://127.0.0.1:8000/api/coutries/all")
          .then(result => setCountries(countries=result['data']))
          .catch(error =>console.log(error))
          }  ,[])

          function save_form(event){
            event.preventDefault();
            setUsers("hello");setToken("fsdfsdfsdfsfsdf")
            // axios.post("http://127.0.0.1:8000/api/register",user)
            //   .then(({data}) => {console.log(data['user']);setUsers(data["user"][0]["firstName"]);setToken(data["user"][1])})
            //   .catch(error => console.log(error))
          }
    return (
      <div>     
          <h1>Login</h1> 
          <form method='post' onSubmit={save_form}>
              <label For="firstName">First Name: </label><input  value={user.firstName} onChange={(e)=>setUser(prevUser =>({...prevUser,firstName:e.target.value}))}  />
               <label For="secondName">Second Name: </label><input type='text'  id='secondName' value={user.secondName} onChange={(e)=>setUser(prevUser =>({...prevUser,secondName:e.target.value}))} />
              <label For="bio">bio: </label><input type='textarea'  id='bio' value={user.bio} onChange={(e)=>setUser(prevUser =>({...prevUser,bio:e.target.value}))} />
              <label For="email">Email: </label><input type='email'  id='email' value={user.email} onChange={(e)=>setUser(prevUser =>({...prevUser,email:e.target.value}))} />
              <label For="password">Password: </label><input type='text'  id='password' value={user.password} onChange={(e)=>setUser(prevUser =>({...prevUser,password:e.target.value}))}/>
              <label For="mobile">Phone: </label><input type='text'  id='mobile' value={user.mobile_number} onChange={(e)=>setUser(prevUser =>({...prevUser,mobile_number:e.target.value}))}/>
              <label For="country">Country: </label>
                  <select value={user.country} onChange={(e)=>setUser(prevUser =>({...prevUser,country:e.target.value}))} className='input'>
                      {countries.map( country=><option value={country} >{country}</option>)}
                  </select>
                  <label For="street">Street Address: </label><input type='text'  id='street' value={user.streetAddress} onChange={(e)=>setUser(prevUser =>({...prevUser,streetAddress:e.target.value}))}/>
                  <label For="province">Province: </label><input type='text'  id='province' value={user.province} onChange={(e)=>setUser(prevUser =>({...prevUser,province:e.target.value}))}/>
                  <label For="city">City: </label><input type='text'  id='city' value={user.city} onChange={(e)=>setUser(prevUser =>({...prevUser,city:e.target.value}))}/>
                  <label For="zipcode">Zipcode: </label><input type='text'  id='zipcode' value={user.zipcode} onChange={(e)=>setUser(prevUser =>({...prevUser,zipcode:e.target.value}))}/>
                  <label For="shipto">Shipping to: </label>
                  <select value={user.ship_to} onChange={(e)=>setUser(prevUser =>({...prevUser,ship_to:e.target.value}))} className='input'>
                      {countries.map( country=><option value={country} >{country}</option>)}
                  </select>
                  <label For="currency">Currency: </label>
                  <select value={user.currency} onChange={(e)=>setUser(prevUser =>({...prevUser,currency:e.target.value}))} className='input'>
                      <option value="LBP">LBP</option>
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                  </select>
                  <label For="user_image">Image:</label><input type='file' id='user_image' value={user.image_url} onChange={(e)=>setUser(prevUser =>({...prevUser,image_url:e.target.value}))} ></input> 
                  <input type='submit' value="register" ></input>

          </form>
          <p>my name {user2}</p>       
      </div>
    )
}
  
