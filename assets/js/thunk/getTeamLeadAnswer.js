import Axios from "axios";
import {
  restartAnswers,
  setAnswersTeamLeadSide,
  restartAnswersTeamLeadSide,
  isActionCalled
} from "../Actions/action";

export const getTeamLeadAnswer = formId => dispatch => {
  dispatch(isActionCalled(false));
  Axios.get(`/api/feedback/${formId}`)
    .then(res => {
      if (res.data === 404) {
        dispatch(restartAnswers());
        dispatch(restartAnswersTeamLeadSide());
      } else {
        dispatch(setAnswersTeamLeadSide(res.data.list));
        console.log("JO");
        console.log(res.data);
      }
    })
    .catch(err => {
      console.log(err);
      console.log("this is teamLead answers get");
    });
};
