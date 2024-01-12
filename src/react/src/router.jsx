import {createBrowserRouter, Navigate} from "react-router-dom";
import Dashboard from "./views/Dashboard.jsx";
import DefaultLayout from "./components/DefaultLayout";
import GuestLayout from "./components/GuestLayout";
import Login from "./views/Login";
import NotFound from "./views/NotFound";
import Signup from "./views/Signup";
import UserReminder from "./views/UserReminder";
import UserReminderForm from "./views/UserReminderForm";

const router = createBrowserRouter([
  {
    path: '/',
    element: <DefaultLayout/>,
    children: [
      {
        path: '/',
        element: <Navigate to="/userReminders"/>
      },
      {
        path: '/dashboard',
        element: <Dashboard/>
      },
      {
        path: '/userReminders',
        element: <UserReminder/>
      },
      {
        path: '/userReminders/new',
        element: <UserReminderForm key="userReminderCreate" />
      },
      {
        path: '/userReminders/:id',
        element: <UserReminderForm key="userReminderUpdate" />
      }
    ]
  },
  {
    path: '/',
    element: <GuestLayout/>,
    children: [
      {
        path: '/login',
        element: <Login/>
      },
      {
        path: '/signup',
        element: <Signup/>
      }
    ]
  },
  {
    path: "*",
    element: <NotFound/>
  }
])

export default router;