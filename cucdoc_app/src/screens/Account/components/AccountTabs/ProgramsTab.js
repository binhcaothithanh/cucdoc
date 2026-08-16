import React from 'react';
import { View, Text, Alert, TouchableOpacity, Image } from 'react-native';
import { useSelector, useDispatch } from 'react-redux';
// import { ACTIVITY_LEVELS } from '../../constants/constants';
import { Pencil, Trash2, ChevronRight, PlusCircle } from 'lucide-react-native';
import { useNavigation } from '@react-navigation/native';
import { deleteProgram } from '../../../../store/slices/programSlice';

import MyButton from '../../../../components/common/MyButton';
import styles from '../../style';
import { useLanguage } from '../../../../i18n/LanguageContext';

const ProgramTab = () => {
    const { t } = useLanguage();
    const dispatch = useDispatch();

    const navigation = useNavigation();
    const { statsHistory } = useSelector((state) => state.user);
    const { profile, loading: userLoading } = useSelector((state) => state.user);
    const onDeleteProgram = (program) => {
        console.log('Xóa giáo án:', program);
        Alert.alert(
            'Xóa giáo án',
            `Bạn có chắc chắn muốn xóa giáo án "${program.program_name}" không? Hành động này không thể hoàn tác.`,
            [
                { text: 'Hủy', style: 'cancel' },
                {
                    text: 'Xóa',
                    style: 'destructive',
                    onPress: async () => {
                        try {
                            // Thực hiện xóa triệt để xuyên suốt tất cả các Slice hệ thống
                            await dispatch(deleteProgram(program.id )).unwrap();
                            // Alert.alert('Thành công', 'Đã gỡ bỏ giáo án thành công khỏi hệ thống.');
                        } catch (error) {
                            Alert.alert('Lỗi', error || 'Không thể xóa giáo án vào lúc này.');
                        }
                    },
                },
            ]
        );
    };
    return (
        <View style={styles.programsContainer}>
            {/* Logic hiển thị ruler và hình ảnh ở đây */}
            {/* <Text>Tab program</Text> */}
            <View style={styles.programsContainer}>
                <View style={styles.sectionHeaderRow}>
                    <Text style={styles.sectionTitleMain}>{t('account.myPrograms')}</Text>
                    <MyButton icon={PlusCircle} iconColor={'#FF6B00'} type="orange" title={t('account.createNew')} style={{ maxHeight: 35, paddingTop: 0, alignItems: 'flex-end', marginRight: 15, paddingHorizontal: 12 }} onPress={() => navigation.navigate('CreateProgramScreen')} />
                </View>

                {/* Đoạn code map giáo án tự tạo */}
                {/* <View style={{borderBottomColor: 'white', borderBottomWidth: 0.2,}}> */}
                {profile?.created_programs?.map((program) => (
                    <TouchableOpacity
                        key={program.id}
                        style={styles.programListCard}
                        onPress={() => navigation.navigate('ProgramDetail', { programId: program.id, returnTo: 'Account' })}
                    >
                        <View style={{ flex: 1 }}>
                            <Text style={styles.programListTitle} numberOfLines={1}>{program.program_name}</Text>
                            <Text style={styles.programListSub}>{program.type}</Text>
                        </View>
                        <View style={styles.row}>
                            {/* 🔥 SỬA TẠI ĐÂY: Loại bỏ việc truyền cả object `program` thừa thãi, chỉ truyền duy nhất programId */}
                            <MyButton
                                icon={Pencil}
                                type="orange"
                                style={styles.miniBtn}
                                onPress={() => navigation.navigate('EditProgram', { programId: program.id })}
                            />
                            <MyButton
                                icon={Trash2}
                                type="red"
                                style={[styles.miniBtn, { marginLeft: 8 }]}
                                onPress={() => onDeleteProgram(program)}
                            />
                        </View>
                    </TouchableOpacity>
                ))}
                {/* </View> */}
                {profile?.saved_programs?.length > 0 && (
                    <View>
                        <Text style={[styles.sectionTitleMain, { marginTop: 32, marginBottom: 16 }]}>{t('account.savedLibrary')}</Text>
                        {profile?.saved_programs?.map((program) => (
                            <TouchableOpacity
                                key={program.id}
                                style={styles.programListCard}
                                onPress={() => navigation.navigate('ProgramDetail', { programId: program.id, returnTo: 'Account' })}
                            >
                                <View style={{ flex: 1 }}>
                                    <Text style={styles.programListTitle} numberOfLines={1}>{program.program_name}</Text>
                                    <Text style={[styles.programListSub, { color: '#64748B' }]}>{t('account.system')}</Text>
                                </View>
                                <ChevronRight size={20} color="#FF6B00" />
                            </TouchableOpacity>
                        ))}
                    </View>
                )}
            </View>
        </View>
    );
};
export default ProgramTab;
