import {useNavigate, useParams} from "react-router-dom";
import {useEffect, useState} from "react";
import axiosClient from "../axios-client.js";
import {useStateContext} from "../context/ContextProvider.jsx";
import moment from "moment";

export default function UserReminderForm() {
    const navigate = useNavigate();
    let {id} = useParams();
    const [userReminder, setUserReminder] = useState({
        title: '',
        description: '',
        event_at: '',
        remind_at: ''
    })
    const [errors, setErrors] = useState(null)
    const [loading, setLoading] = useState(false)
    const {setNotification} = useStateContext()

    const unixToFormattedDateTime= (unixTimestamp) =>{
        const formattedDateTime = moment.unix(unixTimestamp).format('YYYY-MM-DDTHH:mm');
        return formattedDateTime;
    }
    
    const formattedDateTimeToUnix= (formattedDateTime) => {
        const unixTimestamp = moment(formattedDateTime, 'YYYY-MM-DDTHH:mm').unix();
        return unixTimestamp;
    }
    
    if (id) {
        useEffect(() => {
        setLoading(true)
        axiosClient.get(`/reminders/${id}`)
            .then(({data}) => {
                setLoading(false)
                var userReminderDetail = data.data
                console.log(userReminderDetail.remind_at)
                var remind_at_moment = unixToFormattedDateTime(userReminderDetail.remind_at);
                var event_at_moment =  unixToFormattedDateTime(userReminderDetail.event_at);
                console.log(remind_at_moment)
                setUserReminder({
                    id:userReminderDetail.id,
                    title: userReminderDetail.title,
                    description: userReminderDetail.description, 
                    remind_at: remind_at_moment,
                    event_at: event_at_moment
                })
            })
            .catch(() => {
            setLoading(false)
            })
        }, [])
    }

    const onSubmit = (ev) => {
        ev.preventDefault()

        const payload = {
            title: userReminder.title,
            description: userReminder.description,
            event_at: formattedDateTimeToUnix(userReminder.event_at),
            remind_at: formattedDateTimeToUnix(userReminder.remind_at)
        }
        if (userReminder.id) {
            axiosClient.put(`/reminders/${userReminder.id}`, payload)
            .then(() => {
                setNotification('User reminder was successfully updated')
                navigate('/userReminders')
            })
            .catch(err => {
                const response = err.response;
                if (response && response.status === 422) {
                setErrors(response.data.errors)
                }
            })
        } else {
            axiosClient.post('/reminders', payload)
            .then(() => {
                setNotification('User reminder was successfully created')
                navigate('/userReminders')
            })
            .catch(err => {
                const response = err.response;
                if (response && response.status === 422) {
                setErrors(response.data.errors)
                }
            })
        }
  }

  return (
    <>
      {userReminder.id && <h1>Update User Reminder: {userReminder.title}</h1>}
      {!userReminder.id && <h1>New User Reminder</h1>}
      <div className="card animated fadeInDown">
        {loading && (
          <div className="text-center">
            Loading...
          </div>
        )}
        {errors &&
          <div className="alert">
            {Object.keys(errors).map(key => (
              <p key={key}>{errors[key][0]}</p>
            ))}
          </div>
        }
        {!loading && (
          <form onSubmit={onSubmit}>
                <label htmlFor="">
                    Title
                    <input value={userReminder.title} onChange={ev => setUserReminder({...userReminder, title: ev.target.value})} placeholder="Title" required/>
                </label>
                <label htmlFor="">
                    Description
                    <input value={userReminder.description} onChange={ev => setUserReminder({...userReminder, description: ev.target.value})} placeholder="Description" required/>
                </label>
                <label htmlFor="">
                    Event At       
                    <input type="datetime-local" value={userReminder.event_at} onChange={ev => setUserReminder({...userReminder, event_at: ev.target.value})} placeholder="Event At" required/>    
                </label> 
                <label htmlFor="">
                    Remind At
                    <input type="datetime-local" value={userReminder.remind_at} onChange={ev => setUserReminder({...userReminder, remind_at: ev.target.value})} placeholder="Remind At" required/>
    
                </label>          
                <button className="btn">Save</button>
          </form>
        )}
      </div>
    </>
  )
}