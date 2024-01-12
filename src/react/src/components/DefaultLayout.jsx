import {Link, Navigate, Outlet} from "react-router-dom";
import { useStateContext } from "../context/ContextProvider";

export default function DefaultLayout() {
    const { user, token, setToken, setUser, setRefreshToken, notification } = useStateContext()
    
    if (!token) {
        return <Navigate to="/login"/>
    }

    const onLogout = (ev) => {
        ev.preventDefault()
        setToken()
        setUser({})
        setRefreshToken()
    }
    return (
        <div id="defaultLayout">
            {/* <aside>
                <Link to="/dashboard"> Dashboard</Link>
                <Link to="/userReminders">Reminders</Link>
            </aside> */}
            <div className="content">
                <header>
                    <div>Hello {user.name}</div>
                    <div>
                        <a onClick={onLogout} className="btn-logout" href="#">Logout</a>
                    </div>
                </header>
                <main>
                    <Outlet />
                </main>
            </div>
            {notification && <div className="notification">{notification}</div>}
        </div>
    )
}