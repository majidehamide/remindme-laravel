import {Navigate, Outlet} from "react-router-dom";
import { useStateContext } from "../context/ContextProvider";
export default function GuestLayout() {
  const { token } = useStateContext();
    if (token) {
        return <Navigate to="/userReminders" />;
    }

  return (
    <div className="login-signup-form animated fadeInDown">
        <div className="form">
            <Outlet />
        </div>
    </div>
  );
}