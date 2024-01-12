import {useEffect, useState} from "react";
import axiosClient from "../axios-client.js";
import {Link} from "react-router-dom";
import { useStateContext } from "../context/ContextProvider.jsx";
import Moment from 'react-moment';

export default function UserReminders() {
    const [userReminders, setUserReminders] = useState([]);
    const [loading, setLoading] = useState(false);
    const { setNotification } = useStateContext()
    const [limit, setLimit] = useState(10)
    const [page, setPage] = useState(1)
    const [totalPage, setTotalPage] = useState(1)

    useEffect(() => {
        getUserReminders();
    }, [page])

    const onDeleteClick = userReminder => {
        if (!window.confirm("Are you sure you want to delete this userReminder?")) {
        return
        }
        axiosClient.delete(`/reminders/${userReminder.id}`)
        .then(() => {
            setNotification('User reminder was successfully deleted')
            getUserReminders()
        })
    }

    const params = {
        limit: limit,
        page: page
    }

    const getUserReminders = () => {
        setLoading(true)
        axiosClient.get('/reminders', {params})
        .then(({ data }) => {
            setUserReminders(data.data.reminders)
            setTotalPage(data.data.total_page)
            setLoading(false)
            setNotification("Successfully get reminders data")
        })
        .catch(() => {
            setLoading(false)
        })
    }

    const onNext = (ev) => {
        setLoading(true)
        setPage(page + 1)
       
    }
    const onBack = (ev) => {
        setLoading(true)
        setPage(page - 1)
    }

  return (
    <div>
        <div style={{display: 'flex', justifyContent: "space-between", alignItems: "center"}}>
            <h1>User Reminders</h1>
            <Link className="btn-add" to="/userReminders/new">Add new</Link>
          </div>
          
          <div className="card animated fadeInDown">
            <div style={{display: 'flex', justifyContent: "flex-start", alignItems: "center",gap: "10px", paddingBottom:"10px"}}>
                {page >1 && <button onClick={onBack} className="btn btn-add">Back</button>}
                {page<totalPage &&<button onClick={onNext} className="btn btn-add">Next</button>}
            </div>
            <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Event At</th>
                <th>Reminder At</th>
                <th>Actions</th>
            </tr>
            </thead>
            {loading &&
                <tbody>
                <tr>
                <td colSpan="5" className="text-center">
                    Loading...
                </td>
                </tr>
                </tbody>
            }
            {!loading &&
                <tbody>
                {userReminders.map(u => (
                <tr key={u.id}>
                    <td>{u.id}</td>
                    <td>{u.title}</td>
                    <td>{u.description}</td>
                    <td><Moment unix>{u.event_at}</Moment> </td>
                    <td><Moment unix>{u.remind_at}</Moment></td>
                    <td>
                    <Link className="btn-edit" to={'/userReminders/' + u.id}>Edit</Link>
                    &nbsp;
                    <button className="btn-delete" onClick={ev => onDeleteClick(u)}>Delete</button>
                    </td>
                </tr>
                ))}
                </tbody>
            }
            </table>
          </div>
         
          
    </div>
  )
}