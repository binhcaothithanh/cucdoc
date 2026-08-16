import { useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { fetchProgramDetail } from '../store/slices/programSlice';

export const useProgramDetail = (programId) => {
    const dispatch = useDispatch();
    const { list, detail } = useSelector(state => state.program);

    // Tìm trong list
    const programFromList = list.find(p => String(p.id) === String(programId));

    // Kiểm tra tính chi tiết dựa trên type
    const isDetailed = programFromList && (
        programFromList.type === 'single'
            ? Array.isArray(programFromList.days) && programFromList.days.length > 0
            : Array.isArray(programFromList.weeks) && programFromList.weeks.length > 0
    );

    useEffect(() => {
        // Chỉ gọi API nếu chưa có data chi tiết
        if (programId && !isDetailed) {
            dispatch(fetchProgramDetail(programId));
        }
    }, [dispatch, programId, isDetailed]);

    // Trả về object programFromList nếu đã có dữ liệu chi tiết, nếu không thì lấy từ detail
    return isDetailed ? programFromList : detail;
};