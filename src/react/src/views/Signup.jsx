import {Link} from "react-router-dom";
import {createRef, useState} from "react";
import axiosClient from "../axios-client.js";
import {useStateContext} from "../context/ContextProvider.jsx";

export default function Signup() {
    const nameRef = createRef()
    const emailRef = createRef()
    const passwordRef = createRef()
    const passwordConfirmationRef = createRef()
    const {setUser, setToken, setRefreshToken} = useStateContext()
    const [errors, setErrors] = useState(null)
    const [message, setMessage] = useState(null)

    const onSubmit = (ev) => {
        ev.preventDefault()

        const payload = {
            name: nameRef.current.value,
            email: emailRef.current.value,
            password: passwordRef.current.value,
            password_confirmation: passwordConfirmationRef.current.value,
        }
        axiosClient.post('/register', payload)
        .then(({data}) => {
                setUser(data.data.user)
                setToken(data.data.access_token);
                setRefreshToken(data.data.refresh_token);
        })
        .catch(err => {
            const response = err.response;
            if (response && (response.status === 422 || response.status=== 404)) {
                setErrors(response.data.errors)
                setMessage(response.data.message)
            }
        })
    }

  return (
 
        <form onSubmit={onSubmit}>
          <h1 className="title">Signup for Free</h1>

          {message && <div className="alert"><p>{message}</p></div>}
          <input ref={nameRef} type="text" placeholder="Full Name"/>
          <input ref={emailRef} type="email" placeholder="Email Address"/>
          <input ref={passwordRef} type="password" placeholder="Password"/>
          <input ref={passwordConfirmationRef} type="password" placeholder="Repeat Password"/>
          <button className="btn btn-block">Signup</button>
          <p className="message">Already registered? <Link to="/login">Sign In</Link></p>
        </form>
  )
}