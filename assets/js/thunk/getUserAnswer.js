import Axios from 'axios';
import { restartAnswers, setAnswersUserSide, restartAnswersUserSide } from '../Actions/action';

export const getUserAnswer = (formId) => (dispatch) =>{
  
    Axios.get(`/api/answers/${formId}`)
      .then(res => {
        if (res.data === 404) {
            dispatch(restartAnswers());
            dispatch(restartAnswersUserSide());
        } else {
          dispatch(setAnswersUserSide(res.data.list))
        }
      })
      .catch(err => console.log(err));
}