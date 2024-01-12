import { Link} from "react-router-dom";
import { createRef, useState} from "react";
import { useStateContext } from "../context/ContextProvider.jsx";
import axiosClient from "../axios-client.js";
export default function Login() {

    const emailRef = createRef()
    const passwordRef = createRef()
    const {setUser, setToken, setRefreshToken} = useStateContext()
    const [errors, setErrors] = useState(null)
    const [message, setMessage] = useState(null)

    const onSubmit = (ev) => {
        ev.preventDefault()

        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value
        }
        axiosClient.post('/session', payload)
        .then(({data}) => {
                setUser(data.data.user)
                setToken(data.data.access_token);
                setRefreshToken(data.data.refresh_token);
        })
        .catch(err => {
            const response = err.response;
            console.log(response);
            if (response && (response.status === 422 || response.status=== 404)) {
                setMessage(response.msg)
            }
            if (response && (response.status=== 401)) {
                setMessage(response.data.msg)
            }
        })
    }
    return (
        <form onSubmit={onSubmit}>
            <h2>Login into your account</h2>
            <br />
            {message && <div className="alert"><p>{message}</p></div>}
            <input ref={emailRef} type="email" placeholder="Email Address" required />
            <input ref={passwordRef} type="password" placeholder="Password" required />
            <button className="btn btn-block">Login</button>

            <p className="message">
                Not Registered? <Link to="/signup">Create Account</Link>
            </p>
        </form>
           
    )
}