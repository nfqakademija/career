import Axios from "axios";
import {
  restartAnswers,
  setAnswersTeamLeadSide,
  restartAnswersTeamLeadSide,
  isActionCalled
} from "../Actions/action";

export const getTeamLeadAnswer = formId => (dispatch, getState) => {
  dispatch(isActionCalled(false));
  Axios.get(`/api/feedback/${formId}`, {
    headers: { Authorization: `Bearer ${getState().token.token}` }
  })
    .then(res => {
      if (res.data === 404) {
        dispatch(restartAnswers());
        dispatch(restartAnswersTeamLeadSide());
      } else {
        dispatch(setAnswersTeamLeadSide(res.data.list));
      }
    })
    .catch(err => {
      console.log(err);
    });
};
