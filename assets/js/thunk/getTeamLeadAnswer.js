import Axios from "axios";
import {
  restartAnswers,
  setAnswersTeamLeadSide,
  restartAnswersTeamLeadSide
} from "../Actions/action";

export const getTeamLeadAnswer = formId => dispatch => {
  Axios.get(`/api/feedback/answers/${formId}`)
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
      console.log("this is teamLead answers get");
    });
};
