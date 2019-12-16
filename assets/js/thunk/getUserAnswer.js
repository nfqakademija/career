import Axios from "axios";
import {
  restartAnswers,
  setAnswersUserSide,
  restartAnswersUserSide,
  isActionCalled
} from "../Actions/action";

export const getUserAnswer = formId => (dispatch, getState) => {
  dispatch(isActionCalled(false));
  Axios.get(`/api/answers/${formId}`, {
    headers: { Authorization: `Bearer ${getState().token.token}` }
  })
    .then(res => {
      if (res.data === 404) {
        dispatch(restartAnswers());
        dispatch(restartAnswersUserSide());
      } else {
        dispatch(setAnswersUserSide(res.data.list));
      }
    })
    .catch(err => console.log(err));
};
